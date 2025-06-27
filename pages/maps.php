<!DOCTYPE html>
<html lang="fr">
    <?php require_once "pages/head.php"; ?>
    <script src="https://cdn.plot.ly/plotly-2.24.1.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="/src/js/maps.js" defer></script>

    <body
        class="w-full bg-cover bg-center bg-no-repeat bg-[#00122C]/50 bg-blend-multiply backdrop-blur-sm"
        style="background-image: url('assets/bg maps.jpg');">
        <div id="wrap">
            <?php require_once "pages/header.php"; ?>

            <div class="p-4" id="body">
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
                                    <input list="listMMSI" type="text" id="mmsi_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1.5 w-full" placeholder="Search by MMSI" required />
                                    <datalist id="listMMSI">
                                        <option>AZERTY</option>
                                    </datalist>
                                </li>
                                <li class="hidden">
                                    <p>45</p>
                                </li>
                            </ul>
                        </div>

                        <button id="applyFilters" type="button"
                                class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 font-small rounded-lg text-sm px-5 py-2.5 text-center">
                            Apply Filters
                        </button>

                        <button id="refreshClusters" type="button"
                                class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 font-small rounded-lg text-sm px-5 py-2.5 text-center">
                            Refresh clusters
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
                                Timestamp
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
                        <tbody id="tableContent"></tbody>
                    </table>

                    <div class="bg-gray-700 text-gray-400 py-2 text-center ">
                        <div>
                        <ul class="mx-auto flex w-full max-w-[415px] items-center justify-between">
                            <li>
                            <button id="previous-page"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-lg px-4 py-2 text-base font-medium text-dark hover:bg-gray-2 ">
                                <span>
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                    d="M11.325 14.825C11.175 14.825 11.025 14.775 10.925 14.65L5.27495 8.90002C5.04995 8.67502 5.04995 8.32503 5.27495 8.10002L10.925 2.35002C11.15 2.12502 11.5 2.12502 11.725 2.35002C11.95 2.57502 11.95 2.92502 11.725 3.15002L6.47495 8.50003L11.75 13.85C11.975 14.075 11.975 14.425 11.75 14.65C11.6 14.75 11.475 14.825 11.325 14.825Z"
                                    fill="currentColor" />
                                </svg>
                                </span>
                                <span class="max-sm:hidden"> Previous </span>
                            </button>
                            </li>
                            <p class="text-base font-medium text-dark ">
                            Page <input type="text" id="pageNumber" class="inline-flex w-[50px] content-end text-right" value="1" max="<?=$pageMax?>"/> to <span id="pageLimit"><?=$pageMax?></span>
                            </p>
                            <li>
                            <button id="next-page"
                                class="inline-flex h-10 items-center justify-center gap-2 rounded-lg px-4 py-2 text-base font-medium text-dark hover:bg-gray-2 ">
                                <span class="max-sm:hidden"> Next </span>
                                <span>
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                    d="M5.67495 14.825C5.52495 14.825 5.39995 14.775 5.27495 14.675C5.04995 14.45 5.04995 14.1 5.27495 13.875L10.525 8.50003L5.27495 3.15002C5.04995 2.92502 5.04995 2.57502 5.27495 2.35002C5.49995 2.12502 5.84995 2.12502 6.07495 2.35002L11.725 8.10002C11.95 8.32503 11.95 8.67502 11.725 8.90002L6.07495 14.65C5.97495 14.75 5.82495 14.825 5.67495 14.825Z"
                                    fill="currentCOlor" />
                                </svg>
                                </span>
                            </button>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>

        <?php require "pages/footer.php" ?>

        </div>
    </body>
</html>