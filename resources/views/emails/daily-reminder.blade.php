<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0; padding:0; background-color:#0f172a; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#0f172a; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color:#1e293b; border-radius: 16px; overflow:hidden; border: 1px solid #334155;">

                    {{-- HEADER --}}
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #2563eb, #7c3aed); padding: 30px; text-align:center;">
                            <div
                                style="width:48px; height:48px; background:rgba(255,255,255,0.2); border-radius:12px; display:inline-block; line-height:48px; font-weight:bold; color:#fff; font-size:18px;">
                                IC</div>
                            <h1 style="color:#ffffff; font-size:22px; margin:12px 0 4px;">{{ $className }}</h1>
                            <p style="color:#dbeafe; font-size:13px; margin:0;">{{ $tanggal }}</p>
                        </td>
                    </tr>

                    {{-- GREETING --}}
                    <tr>
                        <td style="padding: 24px 30px 0;">
                            <p style="color:#e2e8f0; font-size:15px; margin:0;">Halo,
                                <strong>{{ $studentName }}</strong>! 👋</p>
                            <p style="color:#94a3b8; font-size:13px; margin:8px 0 0;">Berikut info kelas untuk hari ini:
                            </p>
                        </td>
                    </tr>

                    {{-- JADWAL --}}
                    <tr>
                        <td style="padding: 20px 30px 0;">
                            <p style="color:#60a5fa; font-size:14px; font-weight:bold; margin:0 0 12px;">📚 JADWAL
                                KULIAH HARI INI</p>

                            @if ($schedules->isEmpty())
                                <p
                                    style="color:#64748b; font-size:13px; background:#0f172a; padding:14px; border-radius:10px; margin:0;">
                                    Tidak ada kuliah hari ini 🎉</p>
                            @else
                                @foreach ($schedules as $s)
                                    <div
                                        style="background:#0f172a; border-left:3px solid {{ $s->color }}; border-radius:8px; padding:12px 14px; margin-bottom:10px;">
                                        <p style="color:#f1f5f9; font-size:14px; font-weight:bold; margin:0;">
                                            {{ $s->subject }}</p>
                                        <p style="color:#94a3b8; font-size:12px; margin:4px 0 0;">
                                            ⏰ {{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}
                                            @if ($s->room)
                                                | 📍 {{ $s->room }}
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                    </tr>

                    {{-- PR HARI INI --}}
                    @if ($homeworksToday->isNotEmpty())
                        <tr>
                            <td style="padding: 20px 30px 0;">
                                <p style="color:#f87171; font-size:14px; font-weight:bold; margin:0 0 12px;">🚨 DEADLINE
                                    HARI INI</p>
                                @foreach ($homeworksToday as $hw)
                                    <div
                                        style="background:#1c1017; border-left:3px solid #ef4444; border-radius:8px; padding:12px 14px; margin-bottom:10px;">
                                        <p style="color:#f1f5f9; font-size:14px; font-weight:bold; margin:0;">
                                            {{ $hw->title }}</p>
                                        <p style="color:#fca5a5; font-size:12px; margin:4px 0 0;">{{ $hw->subject }}
                                            @if ($hw->due_time)
                                                · ⏰ {{ \Carbon\Carbon::parse($hw->due_time)->format('H:i') }} WIB
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endif

                    {{-- PR BESOK --}}
                    @if ($homeworksTomorrow->isNotEmpty())
                        <tr>
                            <td style="padding: 20px 30px 0;">
                                <p style="color:#fbbf24; font-size:14px; font-weight:bold; margin:0 0 12px;">⚠️ DEADLINE
                                    BESOK</p>
                                @foreach ($homeworksTomorrow as $hw)
                                    <div
                                        style="background:#1c1810; border-left:3px solid #f59e0b; border-radius:8px; padding:12px 14px; margin-bottom:10px;">
                                        <p style="color:#f1f5f9; font-size:14px; font-weight:bold; margin:0;">
                                            {{ $hw->title }}</p>
                                        <p style="color:#fcd34d; font-size:12px; margin:4px 0 0;">{{ $hw->subject }}
                                        </p>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endif

                    {{-- PR MENDATANG --}}
                    @if ($homeworksUpcoming->isNotEmpty())
                        <tr>
                            <td style="padding: 20px 30px 0;">
                                <p style="color:#60a5fa; font-size:14px; font-weight:bold; margin:0 0 12px;">📋 TUGAS
                                    MENDATANG</p>
                                @foreach ($homeworksUpcoming as $hw)
                                    <p
                                        style="color:#cbd5e1; font-size:13px; margin:0 0 8px; padding-left:8px; border-left:2px solid #334155;">
                                        [{{ $hw->subject }}] {{ $hw->title }} —
                                        {{ $hw->due_date->isoFormat('D MMM') }}
                                    </p>
                                @endforeach
                            </td>
                        </tr>
                    @endif

                    @if ($homeworksToday->isEmpty() && $homeworksTomorrow->isEmpty() && $homeworksUpcoming->isEmpty())
                        <tr>
                            <td style="padding: 20px 30px 0;">
                                <p style="color:#4ade80; font-size:14px; font-weight:bold; margin:0 0 12px;">✅ TUGAS /
                                    PR</p>
                                <p
                                    style="color:#64748b; font-size:13px; background:#0f172a; padding:14px; border-radius:10px; margin:0;">
                                    Tidak ada tugas mendatang. Santai dulu! 😊</p>
                            </td>
                        </tr>
                    @endif

                    {{-- FOOTER --}}
                    <tr>
                        <td style="padding: 30px; text-align:center; border-top:1px solid #334155; margin-top:20px;">
                            <p style="color:#475569; font-size:11px; margin:0;">Email ini dikirim otomatis melalui
                                InfoClass 🎓</p>
                            <p style="color:#334155; font-size:10px; margin:6px 0 0;">Kamu menerima ini karena terdaftar
                                sebagai siswa di {{ $className }}</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
