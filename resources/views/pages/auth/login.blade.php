<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#507db4] to-[#2b4c78] font-sans selection:bg-white/30">
    <div class="relative w-full max-w-[340px] px-4 md:max-w-[400px]">
        
        {{-- Glass Card / Panel --}}
        <div class="relative bg-gradient-to-b from-[#3b5e8f] to-[#284877] rounded-[24px] shadow-[0_20px_40px_-10px_rgba(0,0,0,0.5)] px-6 pt-[72px] pb-[32px] flex flex-col items-center">
            
            {{-- Avatar overlapping top edge --}}
            <div class="absolute -top-[52px] left-1/2 -translate-x-1/2 w-[104px] h-[104px] rounded-full bg-[#416a9a] p-[4px] shadow-[0_5px_15px_rgba(0,0,0,0.2)]">
                <div class="w-full h-full rounded-full bg-[#82acd0] flex items-center justify-center overflow-hidden flex-col pt-[18px]">
                    <svg class="w-[84px] h-[84px] text-[#bddbef] translate-y-1" fill="currentColor" viewBox="0 0 24 24">
                        <path stroke="none" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>
            </div>

            <h1 class="text-white text-base font-bold tracking-[0.1em] mb-7">MEMBER LOGIN</h1>

            <x-auth-session-status class="mb-4 text-center text-xs text-green-300" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="w-full space-y-4">
                @csrf

                <!-- Username (Email) -->
                <div class="w-full">
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        required 
                        autofocus 
                        placeholder="USERNAME"
                        value="{{ old('email') }}"
                        class="w-full bg-transparent border-[1.5px] border-white/70 rounded-xl h-[46px] px-4 text-white text-center text-[13px] placeholder:text-white/90 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all"
                    />
                </div>

                <!-- Password -->
                <div class="w-full">
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required 
                        placeholder="PASSWORD"
                        class="w-full bg-transparent border-[1.5px] border-white/70 rounded-xl h-[46px] px-4 text-white text-center text-[13px] placeholder:text-white/90 focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all"
                    />
                </div>

                <!-- Login Button -->
                <div class="pt-[14px]">
                    <button type="submit" class="w-[80%] mx-auto block h-[46px] bg-[#93bade] hover:bg-[#a6caeb] active:bg-[#83a9cc] text-white font-bold tracking-[0.05em] text-sm rounded-full transition-all shadow-[0_4px_10px_rgba(0,0,0,0.1)]">
                        LOGIN
                    </button>
                </div>

                <!-- Remember Me -->
                <div class="pt-4 flex items-center justify-center gap-[10px]">
                    <div class="relative flex items-center justify-center">
                        <input id="remember" name="remember" type="checkbox" class="peer appearance-none w-[18px] h-[18px] border-[1.5px] border-white/90 rounded-[4px] bg-transparent cursor-pointer checked:bg-transparent checked:border-white transition-all focus:ring-0 focus:ring-offset-0">
                        <svg class="absolute w-[14px] h-[14px] text-white pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <label for="remember" class="text-white/90 text-[13px] font-medium cursor-pointer select-none">Remember me</label>
                </div>
            </form>
        </div>

        {{-- Forgot Password --}}
        @if (Route::has('password.request'))
            <div class="mt-8 text-center pb-8">
                <a href="{{ route('password.request') }}" wire:navigate class="text-white/80 text-[13px] hover:text-white transition-colors">
                    Forgot password?
                </a>
            </div>
        @endif

    </div>
</div>
