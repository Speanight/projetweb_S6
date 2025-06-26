<?php
require_once("header.php");
?>
<script src="https://cdn.plot.ly/plotly-2.24.1.min.js" defer></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="/src/js/maps.js" defer></script>

<body
        class="min-h-screen w-full bg-cover bg-center bg-no-repeat bg-[#00122C]/50 bg-blend-multiply backdrop-blur-sm overflow-hidden"
        style="background-image: url('assets/bg maps.jpg');"
>
<div class="p-4">
    <!-- General container -->
    <div class="flex flex-row gap-6">
        <!-- Filter widget -->
        <div class="flex flex-col gap-4">
            <div class="z-10 w-56 p-3 bg-white rounded-lg shadow">
                <h6 class="mb-3 text-sm font-medium text-gray-900">
                    Category
                </h6>
                <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                    <li class="flex items-center">
                        <input id="passenger" type="checkbox"
                               class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2 dark:bg-gray-600" />
                        <label for="passenger" class="ml-2 text-sm font-medium text-gray-900">
                            Passenger
                        </label>
                    </li>
                    <li class="flex items-center">
                        <input id="cargo" type="checkbox"
                               class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2" />
                        <label for="cargo" class="ml-2 text-sm font-medium text-gray-900">
                            Cargo
                        </label>
                    </li>
                    <li class="flex items-center">
                        <input id="tanker" type="checkbox"
                               class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2" />
                        <label for="tanker" class="ml-2 text-sm font-medium text-gray-900">
                            Tanker
                        </label>
                    </li>
                    <li>
                        <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1.5 w-full" placeholder="Search by MMSI" required />
                    </li>
                    <li class="hidden">
                        <p>45</p>
                    </li>
                </ul>
            </div>

            <button type="button"
                    class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 font-small rounded-lg text-sm px-5 py-2.5 text-center">
                Apply Filters
            </button>
        </div>

        <!-- Map -->
        <div id="map" class="w-full h-[600px] rounded-xl overflow-hidden"></div>
    </div>


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg m-8 mt-3">
        <table class="w-full text-sm text-left rtl:text-right text-gray-400">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    MMSI
                </th>
                <th scope="col" class="px-6 py-3">
                    LAT / LON
                </th>
                <th scope="col" class="px-6 py-3">
                    SOG / COG / Heading
                </th>
                <th scope="col" class="px-6 py-3">
                    Length / Width / Draft
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
                <tr class="border-b bg-gray-800 border-gray-700 hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
                        Apple MacBook Pro 17"
                    </th>
                    <td class="px-6 py-4">
                        Silver
                    </td>
                    <td class="px-6 py-4">
                        Laptop
                    </td>
                    <td class="px-6 py-4">
                        Yes
                    </td>
                    <td class="px-6 py-4">
                        Yes
                    </td>
                    <!-- Buttons for prediction -->
                    <td class="flex items-center px-6 py-4">
                        <!-- Section for button and modal -->
                        <section x-data="{modalOpen: false}">
                            <button @click="modalOpen = true" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-gray text-white focus:ring-4 focus:outline-none focus:ring-cyan-800">
                                <span class="relative px-5 transition-all ease-in duration-75 bg-gray-900 rounded-md  group-hover:bg-transparent">
                                Predict type
                                </span>
                            </button>

                            <div x-show="modalOpen" x-transition
                                 class="fixed left-0 top-0 flex h-full min-h-screen w-full items-center justify-center bg-dark/90 px-4 py-5">
                                <div @click.outside="modalOpen = false"
                                     class="w-full max-w-[570px] rounded-[20px] bg-white px-8 py-12 text-center md:px-[70px] md:py-[60px]">
                                    <h3 class="pb-[18px] text-xl font-semibold text-dark sm:text-2xl">
                                        The ship is predicted to be a
                                    </h3>
                                    <span class="mx-auto mb-6 inline-block h-1 w-[90px] rounded-sm bg-blue-500"></span>                                    <p class="mb-10 text-base leading-relaxed text-body-color">
                                        Please note that our model is only able to predict Passager, Cargo and Tanker.
                                    </p>
                                </div>
                            </div>
                        </section>

                        <section x-data="{modalOpen: false}">
                            <button @click="modalOpen = true" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-gray text-white focus:ring-4 focus:outline-none focus:ring-cyan-800">
                                <span class="relative px-5 transition-all ease-in duration-75 bg-gray-900 rounded-md  group-hover:bg-transparent">
                                Predict trajectory
                                </span>
                            </button>

                            <div x-show="modalOpen" x-transition
                                 class="fixed left-0 top-0 flex h-full min-h-screen w-full items-center justify-center bg-dark/90 px-4 py-5">
                                <div @click.outside="modalOpen = false"
                                     class="w-full max-w-[570px] rounded-[20px] bg-white px-8 py-12 text-center md:px-[70px] md:py-[60px]">
                                    <h3 class="pb-[18px] text-xl font-semibold text-dark sm:text-2xl">
                                        Predict your ship position !
                                    </h3>
                                    <span class="mx-auto mb-6 inline-block h-1 w-[90px] rounded-sm bg-blue-500"></span>                                    <p class="mb-10 text-base leading-relaxed text-body-color">
                                        You can predict your ship position after a specific time by using below buttons.
                                    </p>
                                    <div class="flex items-center gap-4">
                                        <div class="relative w-3/4">
                                            <input type="number" id="timestamp" name="timestamp"
                                                   class="w-full pr-12 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                                   min="1" step="1" required
                                                   placeholder="Durée"
                                            />
                                            <span class="absolute inset-y-0 right-3 flex items-center text-gray-500 text-sm">
                                                min
                                            </span>
                                        </div>
                                        <div class="w-1/4">
                                            <button type="button"
                                                    class="w-full text-white font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-800">
                                                Valider
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Pred answer -->
                                    <div class="mt-6">
                                        <span class=" inline-block h-1 w-[90px] rounded-sm bg-blue-500"></span>                                    <p class="mb-10 text-base leading-relaxed text-body-color">
                                        <p>Your ship is predicted to be at POS after X minutes</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


</div>
</body>
</html>
