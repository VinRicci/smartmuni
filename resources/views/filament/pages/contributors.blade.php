<style>


    .bg-panel-700 {
        --tw-bg-opacity: 1;
        background-color: rgb(25 48 78/var(--tw-bg-opacity));
    }

    .bg-panel-700 {
        --tw-bg-opacity: 1;
        background-color: rgb(25 48 78/var(--tw-bg-opacity));
    }

    .bg-panel-800 {
        --tw-bg-opacity: 1;
        background-color: rgb(24 39 63/var(--tw-bg-opacity));
    }

    .bg-panel-800 {
        --tw-bg-opacity: 1;
        background-color: rgb(24 39 63/var(--tw-bg-opacity));
    }

    .flex-center {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .flex-center {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<section class="max-w-none md:pb-[35px]">
    <div class="container" style="max-width: 1300px;">
        <header class="container mx-auto mb-4 max-w-[700px] pb-1 text-center dark:text-white text-black"><img
                loading="lazy" class="lazy absolute hidden mix-blend-luminosity lg:inline-block lazyloaded"
                src="https://laracasts.com/images/home/teacher-grid-bg.svg">
            <h3 class="inherits-color relative z-10 text-5xl font-semibold leading-tight text-balance tracking-tight">
                {{ config('contributors.title') }}</h3>
            <p class="inherits-color mt-4 font-semibold text-grey-600 text-balance">
                {{ config('contributors.title_available') }}
            </p>
        </header>
        <div id="instructor-cards"
            class="mt-6 grid gap-x-12 gap-y-10 lg:grid-cols-2 lg:gap-y-16 lg:gap-y-20 xl:mt-[90px] xl:grid-cols-3">
            @foreach (config('contributors.team') as $key => $value)
                <div
                    class="dark:panel relative transition-colors duration-300 dark  text-white bg-panel-800 hover:bg-panel-700 py-4 rounded-xl group px-4 lg:h-[242px]">
                    <div class="flex gap-10">
                        <aside class="w-32" style="flex: 0 1 0%;">
                            <div class="absolute top-0 left-0 rounded-full bg-gradient-languages"
                                style="width: 115px; height: 115px; top: -17px;"></div>
                            <div class="relative"
                                style="width: 105px; height: 164px; margin-top: -15px; margin-left: -5px;"><img
                                    loading="lazy"
                                    class="lazy h-full w-full border-6 border-blue-darkest object-cover lazyloaded"
                                    src="{{ $value['avatar'] }}" alt="Photo of Jeffrey Way" width="105"
                                    height="164"
                                    style="border-radius: 66px; margin-top: -6px; box-shadow: rgba(120, 144, 156, 0.07) 0px 0px 0px 1px;">
                            </div>
                            <div class="flex-center mt-1 gap-2"><a href="{{ $value['linkedin'] }}" target="_blank"
                                    class="flex-center h-8 w-8 rounded-md bg-panel-700 group-hover:bg-panel-600 group-hover:hover:bg-blue/15">
                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 15 15">
                                        <path fill-rule="evenodd"
                                            d="M7.979 5v1.586a3.5 3.5 0 0 1 3.082-1.574C14.3 5.012 15 7.03 15 9.655V15h-3v-4.738c0-1.13-.229-2.584-1.995-2.584-1.713 0-2.005 1.23-2.005 2.5V15H5.009V5h2.97ZM3 2.487a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                            clip-rule="evenodd" />
                                        <path d="M3 5.012H0V15h3V5.012Z" />
                                    </svg>

                                </a><a href="{{ $value['github'] }}" target="_blank"
                                    class="flex-center h-8 w-8 rounded-md bg-panel-700 group-hover:bg-panel-600 group-hover:hover:bg-blue/15"><svg
                                        width="20" height="29" viewBox="0 0 30 29" class="text-grey-600">
                                        <path class="fill-current" fill-rule="nonzero"
                                            d="M27.959 7.434a14.866 14.866 0 0 0-5.453-5.414C20.21.69 17.703.025 14.984.025c-2.718 0-5.226.665-7.521 1.995A14.864 14.864 0 0 0 2.01 7.434C.67 9.714 0 12.202 0 14.901c0 3.242.953 6.156 2.858 8.746 1.906 2.589 4.367 4.38 7.385 5.375.351.064.611.019.78-.136a.755.755 0 0 0 .254-.58l-.01-1.047c-.007-.658-.01-1.233-.01-1.723l-.448.077a5.765 5.765 0 0 1-1.083.068 8.308 8.308 0 0 1-1.356-.136 3.04 3.04 0 0 1-1.308-.58c-.403-.304-.689-.701-.858-1.192l-.195-.445a4.834 4.834 0 0 0-.614-.988c-.28-.362-.563-.607-.85-.736l-.136-.097a1.428 1.428 0 0 1-.253-.233 1.062 1.062 0 0 1-.176-.271c-.039-.09-.007-.165.098-.223.104-.059.292-.087.566-.087l.39.058c.26.052.582.206.965.465.384.258.7.594.947 1.007.299.53.66.933 1.082 1.21.423.278.85.417 1.278.417.43 0 .8-.032 1.112-.097a3.9 3.9 0 0 0 .878-.29c.117-.866.436-1.53.956-1.996a13.447 13.447 0 0 1-2-.348 7.995 7.995 0 0 1-1.833-.756 5.244 5.244 0 0 1-1.571-1.298c-.416-.516-.758-1.195-1.024-2.034-.267-.84-.4-1.808-.4-2.905 0-1.563.514-2.893 1.541-3.99-.481-1.176-.436-2.493.137-3.952.377-.116.936-.03 1.678.261.741.291 1.284.54 1.629.746.345.207.621.381.83.523a13.948 13.948 0 0 1 3.745-.503c1.288 0 2.537.168 3.747.503l.741-.464c.507-.31 1.106-.595 1.795-.853.69-.258 1.216-.33 1.58-.213.586 1.46.638 2.777.156 3.951 1.028 1.098 1.542 2.428 1.542 3.99 0 1.099-.134 2.07-.4 2.916-.267.846-.611 1.524-1.034 2.034-.423.51-.95.94-1.58 1.288a8.01 8.01 0 0 1-1.834.756c-.592.155-1.259.271-2 .349.676.58 1.014 1.498 1.014 2.75v4.087c0 .232.081.426.244.58.163.155.42.2.77.136 3.019-.994 5.48-2.786 7.386-5.375 1.905-2.59 2.858-5.504 2.858-8.746 0-2.698-.671-5.187-2.01-7.466z">
                                        </path>
                                    </svg></a></div>
                        </aside>
                        <div class="pb-6"><a href="/series/code-breaking-workshop">
                                <h4 class="text-2xl font-medium leading-tight">
                                    {{ $value['name'] }}
                                </h4>
                            </a>
                            <p class="mt-1 text-xs text-grey-600">{{ $value['position'] }}</p>
                            <p class="clamp mt-4 pr-8 text-xs text-grey-100" style="-webkit-line-clamp: 6;">
                                {{ $value['description'] }}</p>
                            <div class="absolute -bottom-6 flex items-start gap-3 md:-bottom-8">

                                @foreach ($value['roles'] as $role => $url)
                                    <img loading="lazy"
                                        class="lazy h-10 w-10 transition-all md:h-[54px] md:w-[54px] lazyloaded"
                                        src="{{ $url }}" alt="Code-Breaking Workshop series thumbnail">
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
