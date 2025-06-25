<?php
require_once("header.php");
?>
<script src="https://cdn.plot.ly/plotly-2.24.1.min.js" defer></script>
<script src="/src/js/maps.js" defer></script>

<body>
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
                               class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2 dark:bg-gray-600" />
                        <label for="cargo" class="ml-2 text-sm font-medium text-gray-900">
                            Cargo
                        </label>
                    </li>
                    <li class="flex items-center">
                        <input id="tanker" type="checkbox"
                               class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2 dark:bg-gray-600" />
                        <label for="tanker" class="ml-2 text-sm font-medium text-gray-900">
                            Tanker
                        </label>
                    </li>
                </ul>
            </div>

            <button type="button"
                    class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 font-small rounded-lg text-sm px-5 py-2.5 text-center">
                Apply Filters
            </button>
        </div>

        <!-- Map -->
        <div id="map" class="w-full h-[600px] rounded-xl overflow-hidden">
        </div>
    </div>
</div>
</body>
</html>
