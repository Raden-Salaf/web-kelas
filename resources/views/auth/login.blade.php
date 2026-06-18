<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — InfoClass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    {{-- Background animasi --}}
    <div class="absolute inset-0 bg-dots opacity-40"></div>
    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl animate-pulse-slow"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-violet-600/20 rounded-full blur-3xl animate-pulse-slow" style="animation-delay:2s"></div>
    <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-cyan-600/10 rounded-full blur-3xl animate-float"></div>

    <div class="relative z-10 w-full max-w-md px-4">

        {{-- Logo --}}
        <div class="text-center mb-8 animate-slide-up">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-violet-600 rounded-2xl flex items-center justify-center mx-auto mb-4 glow">
                <span class="text-2xl font-black">IC</span>
            </div>
            <h1 class="text-3xl font-black gradient-text">InfoClass</h1>
            <p class="text-slate-400 text-sm mt-1">
                {{ \App\Models\SiteSetting::getValue('class_name', 'Kelas TIF') }}
            </p>
        </div>

        {{-- Card Login --}}
        <div class="glass rounded-2xl p-8 animate-fade-in">
            <h2 class="text-xl font-bold text-center mb-6">Masuk ke Akun Kamu</h2>

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="email@kamu.com"
                           class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <div class="relative" x-data="{ show: false }">
                       <input :type="show ? 'text' : 'password'" name="password" required
                               placeholder="••••••••"
                               class="w-full bg-slate-800/50 border border-blue-500/30 rounded-xl px-4 py-3 pr-12 text-white placeholder-slate-500 focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400 transition">
                        <button type="button" @click="show = !show"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white">
                            <span x-show="!show">👁️</span>
                            <span x-show="show">🙈</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-400 cursor-pointer">
                        <input type="checkbox" name="remember"
                               class="rounded border-slate-600 bg-slate-800 text-blue-500 focus:ring-blue-500">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 text-white font-semibold py-3 rounded-xl transition glow-sm">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('landing') }}" class="text-slate-500 hover:text-slate-300 text-sm transition">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <p class="text-center text-slate-600 text-xs mt-6">
            Belum punya akun? Hubungi admin kelas kamu.
        </p>
    </div>

</body>
</html>