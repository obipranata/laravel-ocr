<div
    class="lg:w-1/3"
    x-data="{
        pusher(){
             pusher = new Pusher('9c8f0648c50b86978839', {
               cluster: 'ap1'
             });

            let channel = pusher.subscribe('ocr-channel');
            channel.bind('ocr-event', function(result) {
                console.log(result);
                if(result.status === 'success'){
                    $wire.getData(result.data);
                }
            });
        }
    }"
    x-init="pusher()"
>
    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white text-center">Scan KTP </h1>
    <form wire:submit="{{$isUploaded ? 'rescan' : 'submit'}}" method="post">
        @if($isUploaded)
            @if($isLoading)
                <x-loading.skeleton/>
            @else
                <livewire:form :data="$data" />
            @endif
        @else
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" wire:model="attachment">
            </div>
        @endif

        <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-1.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900 mt-4">{{$isUploaded ? 'Rescan' : 'Submit'}}</button>
    </form>
</div>
