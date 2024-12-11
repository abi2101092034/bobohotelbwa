<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Cities') }}
            </h2>
            <a href=" {{ route('admin.cities.create') }} "
                class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Add New
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">

                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2 text-center">Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Date</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cities as $city)
                            <tr class="hover:bg-yellow-100">
                                <td class="border border-gray-300 px-4 py-2">
                                    <h3 class="text-indigo-950 text-lg font-bold">
                                        {{ $city->name }}
                                    </h3>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <h3 class="text-indigo-950 text-lg font-bold">
                                        {{ $city->created_at->format('M d, Y') }}
                                    </h3>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('admin.cities.edit', $city) }}"
                                            class="font-bold py-2 px-4 bg-indigo-700 text-white rounded-full">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.cities.destroy', $city) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="font-bold py-2 px-4 bg-red-700 text-white rounded-full">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center border border-gray-300 px-4 py-2">
                                    Belum Ada Data Terbaru
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                {{ $cities->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
