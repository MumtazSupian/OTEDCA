<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PiutangController extends Controller
{
    private const GR_BRANCHES = ['cinere', 'jatiasih', 'cianjur', 'ciawi'];

    public function indexBp()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $records = Piutang::where('branch', 'bp')->orderByDesc('tgl_bukti')->orderByDesc('id')->get();

        $totalSaldoAwal = $records->sum('saldo_awal');
        $totalDebet = $records->sum('debet');
        
        $totalKredit = $records->sum(function ($item) {
            return ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0);
        });
        
        $totalSaldoAkhir = $records->sum('saldo_akhir');

        $totalSelisih = $records->sum(function ($item) {
            $totalRealKredit = ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0);
            return ($item->saldo_awal + $item->debet - $totalRealKredit) - $item->saldo_akhir;
        });

        return view('BP.index', [
            'records' => $records,
            'totalSaldoAwal' => $totalSaldoAwal,
            'totalDebet' => $totalDebet,
            'totalKredit' => $totalKredit,
            'totalSaldoAkhir' => $totalSaldoAkhir,
            'totalSelisih' => $totalSelisih,
        ]);
    }

    public function storeBp(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_unless(($user->is_admin ?? false), 403, 'Unauthorized action.');

        return $this->store($request, 'bp');
    }

    public function editBp($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $record = Piutang::where('branch', 'bp')->findOrFail($id);

        return view('BP.edit', compact('record', 'id'));
    }

    public function updateBp(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $record = Piutang::where('branch', 'bp')->findOrFail($id);

        $data = $this->validateData($request, true, $record);
        
        unset($data['tgl_bukti'], $data['no_bukti'], $data['saldo_awal']);
        $data['saldo_awal'] = $record->saldo_awal;

        $data = $this->preserveHiddenPaymentStages($data, $record);
        $data = $this->normalizeNumericData($data);

        $data['kredit'] = $data['kredit_stage1'] ?? $record->kredit;
        $data['kredit_2'] = $data['kredit_stage2'] ?? $record->kredit_2;
        $data['kredit_3'] = $data['kredit_stage3'] ?? $record->kredit_3;

        $this->enforcePaymentRules($data, $record, 'bp');

        $data['saldo_akhir'] = $this->calculateSaldoAkhir($data, $record);

        $record->update($data);

        return redirect('/bp');
    }

    public function destroyBp($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_unless(($user->is_admin ?? false), 403, 'Unauthorized action.');

        $record = Piutang::where('branch', 'bp')->findOrFail($id);
        $record->delete();

        return redirect('/bp');
    }
    

    public function indexGr($branch)
    {
        $this->validateBranch($branch);

        $records = Piutang::with('perusahaan')
            ->where('branch', $branch)
            ->orderByDesc('tgl_bukti')
            ->orderByDesc('id')
            ->get();

        $totalSaldoAwal = $records->sum('saldo_awal');
        $totalDebet = $records->sum('debet');

        $totalKredit = $records->sum(function ($item) {
            return ($item->kredit ?? 0)
                + ($item->kredit_2 ?? 0)
                + ($item->kredit_3 ?? 0);
        });

        $totalSaldoAkhir = $records->sum('saldo_akhir');

        $totalSelisih = $records->sum(function ($item) {
            $totalRealKredit = ($item->kredit ?? 0)
                + ($item->kredit_2 ?? 0)
                + ($item->kredit_3 ?? 0);

            return ($item->saldo_awal + $item->debet - $totalRealKredit)
                - $item->saldo_akhir;
        });

        $perusahaans = \App\Models\Perusahaan::orderBy('nama', 'asc')->get();

        return view("GR.$branch.index", compact(
            'records',
            'totalSaldoAwal',
            'totalDebet',
            'totalKredit',
            'totalSaldoAkhir',
            'totalSelisih',
            'perusahaans'
        ));
    }

    public function storeGr(Request $request, $branch)
    {
        $this->validateBranch($branch);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_unless(($user->is_admin ?? false), 403, 'Unauthorized action.');

        return $this->store($request, $branch);
    }

    public function editGr($branch, $id)
    {
        $this->validateBranch($branch);

        $record = Piutang::where('branch', $branch)->findOrFail($id);

        $perusahaans = \App\Models\Perusahaan::orderBy('nama', 'asc')->get();

        return view("GR.$branch.edit", compact('record', 'id', 'perusahaans'));
    }

    public function updateGr(Request $request, $branch, $id)
    {
        $this->validateBranch($branch);

        return $this->update($request, $branch, $id);
    }

    public function destroyGr($branch, $id)
    {
        $this->validateBranch($branch);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_unless(($user->is_admin ?? false), 403, 'Unauthorized action.');

        Piutang::where('branch', $branch)->findOrFail($id)->delete();

        return redirect("/gr/$branch");
    }

    private function validateBranch(string $branch): void
    {
        if (! in_array($branch, self::GR_BRANCHES, true)) {
            abort(404);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== $branch, 403, 'Unauthorized action.');
    }

    private function store(Request $request, string $branch)
    {
        $data = $this->validateData($request);

        if (($data['tipe_konsumen'] ?? '') === 'reguler') {
            $data['perusahaan_id'] = null;
        }

        $data = $this->normalizeNumericData($data);
        $data['branch'] = $branch;

        if (in_array($branch, self::GR_BRANCHES, true) && isset($data['spk_type']) && $data['spk_type'] === 'ASURANSI') {
            abort(422, 'GR branches do not accept ASURANSI spk type.');
        }

        $data['debet'] = 0;
        $data['kredit'] = 0;
        $data['kredit_2'] = 0;
        $data['kredit_3'] = 0;
        unset($data['tgl_bukti_rek'], $data['no_bukti_rek'], $data['keterangan']);
        unset($data['tgl_bukti_rek_2'], $data['no_bukti_rek_2'], $data['keterangan_2']);
        unset($data['tgl_bukti_rek_3'], $data['no_bukti_rek_3'], $data['keterangan_3']);

        if (isset($data['saldo_awal']) && $data['saldo_awal'] !== null && $data['saldo_awal'] !== '') {
            $data['saldo_akhir'] = floatval($data['saldo_awal']);
        } else {
            $data['saldo_akhir'] = 0;
        }

        Piutang::create($data);

        return redirect($branch === 'bp' ? '/bp' : "/gr/$branch");
    }

    private function update(Request $request, string $branch, $id)
    {
        $record = Piutang::where('branch', $branch)->findOrFail($id);
        
        $data = $this->validateData($request, true, $record, $branch);

        if (($data['tipe_konsumen'] ?? '') === 'reguler') {
            $data['perusahaan_id'] = null;
        }

        unset($data['tgl_bukti'], $data['no_bukti'], $data['saldo_awal']);
        $data['saldo_awal'] = $record->saldo_awal;

        $data = $this->preserveHiddenPaymentStages($data, $record);
        $data = $this->normalizeNumericData($data);

        $data['kredit'] = $data['kredit_stage1'] ?? 0;
        $data['kredit_2'] = $data['kredit_stage2'] ?? 0;
        $data['kredit_3'] = $data['kredit_stage3'] ?? 0;

        $this->enforcePaymentRules($data, $record, $branch);

        $data['saldo_akhir'] = $this->calculateSaldoAkhir($data, $record);

        $record->update($data);

        return redirect($branch === 'bp' ? '/bp' : "/gr/$branch");
    }

    private function validateData( Request $request, bool $isUpdate = false, $record = null, ?string $branch = null): array
    {
        $numericKeys = ['saldo_awal', 'debet', 'kredit', 'saldo_akhir', 'kredit_stage1', 'kredit_stage2', 'kredit_stage3'];
        foreach ($numericKeys as $key) {
            if ($request->has($key) && $request->input($key) !== null) {
                $cleanValue = str_replace('.', '', $request->input($key));
                $cleanValue = str_replace(',', '.', $cleanValue);
                $request->merge([$key => $cleanValue]);
            }
        }

        $base = [
            'nama_konsumen' => ['nullable', 'string', 'max:255'],
            'tipe_konsumen' => ['nullable', 'string', 'in:reguler,perusahaan'],
            'perusahaan_id' => ['nullable', 'exists:perusahaan,id'],
            'nama_asuransi' => ['nullable', 'string', 'max:255'],
            'tgl_bukti' => ['nullable', 'date'],
            'no_bukti' => ['nullable', 'string', 'max:100'],
            'saldo_awal' => ['nullable', 'numeric'],
            'debet' => ['nullable', 'numeric'],
            'kredit' => ['nullable', 'numeric'],
            'tgl_bukti_rek' => ['nullable', 'date'],
            'no_bukti_rek' => ['nullable', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'kredit_stage1' => ['nullable', 'numeric'],
            'tgl_bukti_rek_2' => ['nullable', 'date'],
            'no_bukti_rek_2' => ['nullable', 'string', 'max:100'],
            'keterangan_2' => ['nullable', 'string', 'max:255'],
            'kredit_stage2' => ['nullable', 'numeric'],
            'tgl_bukti_rek_3' => ['nullable', 'date'],
            'no_bukti_rek_3' => ['nullable', 'string', 'max:100'],
            'keterangan_3' => ['nullable', 'string', 'max:255'],
            'kredit_stage3' => ['nullable', 'numeric'],
            'no_polisi' => ['nullable', 'string', 'max:100'],
            'no_polis' => ['nullable', 'string', 'max:100'],
            'spk_type' => ['nullable', 'string', 'in:ASURANSI,REGULER,INTERNAL'],
            'no_spk' => ['nullable', 'string', 'max:100'],
            'saldo_akhir' => ['nullable', 'numeric'],
        ];

        if ($isUpdate) {
            $base['no_spk'] = ['required', 'string', 'max:100'];
            $base['nama_konsumen'] = ['required', 'string', 'max:255'];
            $base['no_polisi'] = ['required', 'string', 'max:100'];
            $base['no_polis'] = [ strtolower($branch) === 'bp' ? 'required' : 'nullable', 'string', 'max:100' ];
            $base['spk_type'] = ['required', 'string', 'in:ASURANSI,REGULER,INTERNAL'];
            $base['tgl_bukti'] = ['required', 'date'];
            $base['no_bukti'] = ['required', 'string', 'max:100'];
            $base['saldo_awal'] = ['required', 'numeric'];
            $base['saldo_akhir'] = ['required', 'numeric'];
            $base['debet'] = ['nullable', 'numeric'];

            if ($record) {
                if (!$record->tgl_bukti_rek) {
                    $base['tgl_bukti_rek'] = ['required', 'date'];
                    $base['keterangan'] = ['required', 'string', 'max:255'];
                    $base['kredit_stage1'] = ['required', 'numeric'];
                } elseif ($record->tgl_bukti_rek && !$record->tgl_bukti_rek_2) {
                    $base['tgl_bukti_rek_2'] = ['required', 'date'];
                    $base['keterangan_2'] = ['required', 'string', 'max:255'];
                    $base['kredit_stage2'] = ['required', 'numeric'];
                } elseif ($record->tgl_bukti_rek_2 && !$record->tgl_bukti_rek_3 && ($record->spk_type === 'ASURANSI' || $request->input('spk_type') === 'ASURANSI')) {
                    $base['tgl_bukti_rek_3'] = ['required', 'date'];
                    $base['keterangan_3'] = ['required', 'string', 'max:255'];
                    $base['kredit_stage3'] = ['required', 'numeric'];
                }
            }
        }

        return $request->validate($base);
    }

    private function normalizeNumericData(array $data): array
    {
        $numericKeys = ['saldo_awal', 'debet', 'kredit', 'kredit_stage1', 'kredit_stage2', 'kredit_stage3'];

        foreach ($numericKeys as $key) {
            if (! isset($data[$key]) || $data[$key] === null || $data[$key] === '') {
                $data[$key] = 0;
            }
        }

        return $data;
    }

    private function calculateSaldoAkhir(array $data, $record = null): float
    {
        $saldoAwal = isset($data['saldo_awal']) ? floatval($data['saldo_awal']) : 0;
        $debet = isset($data['debet']) ? floatval($data['debet']) : ($record ? floatval($record->debet) : 0);
        
        $kredit1 = isset($data['kredit']) ? floatval($data['kredit']) : 0;
        $kredit2 = isset($data['kredit_2']) ? floatval($data['kredit_2']) : 0;
        $kredit3 = isset($data['kredit_3']) ? floatval($data['kredit_3']) : 0;

        return $saldoAwal + $debet - ($kredit1 + $kredit2 + $kredit3);
    }

    private function enforcePaymentRules(array &$data, Piutang $record, string $branch): void
    {
        $spk = $data['spk_type'] ?? $record->spk_type ?? null;
        if (in_array($branch, self::GR_BRANCHES, true) && $spk === 'ASURANSI') {
            abort(422, 'GR branches do not accept ASURANSI spk type.');
        }

        if (array_key_exists('debet', $data)) {
            $newDebet = floatval($data['debet']);
            if ($record->debet && $newDebet !== floatval($record->debet)) {
                abort(422, 'Debet hanya bisa diinput sekali.');
            }
        }
    }

    private function preserveHiddenPaymentStages(array $data, Piutang $record): array
    {
        foreach (
            [
                'tgl_bukti_rek_2',
                'no_bukti_rek_2',
                'keterangan_2',
                'tgl_bukti_rek_3',
                'no_bukti_rek_3',
                'keterangan_3',
            ] as $field
        ) {
            if (array_key_exists($field, $data) && ($data[$field] === null || $data[$field] === '')) {
                unset($data[$field]);
            }
        }

        return $data;
    }
}