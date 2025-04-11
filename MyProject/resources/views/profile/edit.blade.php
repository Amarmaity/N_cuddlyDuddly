<x-app-layout>
 <section class="wsus__product mt_145 pb_100">
        <div class="container">
           <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <br>
            <br>
            <div class="">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
    </section>

</x-app-layout>
