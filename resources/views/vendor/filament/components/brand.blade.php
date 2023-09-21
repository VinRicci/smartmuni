@auth
<img src="{{ asset('logo-0.png') }}" class="block dark:hidden h-48 mx-auto" />
<img src="{{ asset('logo-5.png') }}" class="hidden dark:block h-48 mx-auto" />
@endauth

@guest
<img src="{{ asset('logo-4.png') }}" class="block dark:hidden h-24 mx-auto" />
<img src="{{ asset('logo-4.png') }}" class="hidden dark:block h-24 mx-auto" />
@endguest
