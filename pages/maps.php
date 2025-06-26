<!DOCTYPE html>
<html lang="fr">
    <?php require_once "pages/head.php"; ?>
    <script src="https://cdn.plot.ly/plotly-2.24.1.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="/src/js/maps.js" defer></script>

    <body
        class="w-full bg-cover bg-center bg-no-repeat bg-[#00122C]/50 bg-blend-multiply backdrop-blur-sm overflow-hidden"
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
                                    <input type="text" id="mmsi_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1.5 w-full" placeholder="Search by MMSI" required />
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
                        <tbody>
                            <?php foreach ($positions as $s): ?>
                                <?php foreach ($s as $p): ?>
                                    <tr class="border-b bg-gray-800 border-gray-700 hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
                                            <?=$p->get_ship()->get_vesselname()?>
                                        </th>
                                        <td class="px-6 py-4">
                                            <?=$p->get_timestamp()->format("d/m/Y G:i")?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?=$p->get_ship()->get_mmsi()?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?=$p->get_lat()?> / <?=$p->get_lon()?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?=$p->get_sog()?> / <?=$p->get_cog()?> / <?=$p->get_heading()?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?=$p->get_ship()->get_length()?> / <?=$p->get_ship()->get_width()?> / <?=$p->get_ship()->get_draft()?>
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
                                                        <h3 class="type-prediction pb-[18px] text-xl font-semibold text-dark sm:text-2xl">
                                                            The ship is predicted to be a <strong class="<?php
                                                            switch ($p->get_ship()->get_type()->get_type()) {
                                                                case 60:
                                                                    ?>text-red-600<?php
                                                                    break;
                                                                case 70:
                                                                    ?>text-lime-600<?php
                                                                    break;
                                                                case '80':
                                                                    ?>text-sky-600<?php
                                                                    break;
                                                            }
                                                            ?>"><?=$p->get_ship()->get_type()->get_description()?></strong>
                                                        </h3>
                                                        <span class="mx-auto mb-6 inline-block h-1 w-[90px] rounded-sm bg-blue-500"></span>                                    <p class="mb-10 text-base leading-relaxed text-body-color">
                                                            Please note that our model is only able to predict Passager, Cargo and Tanker. If you're willing to manually adjust your ship type, you may do so thanks to the dropdown below.
                                                        </p>
                                                        
                                                        <div class="flex items-center gap-4">
                                                            <div class="relative w-3/4">
                                                                <div class="container">
                                                                    <div>
                                                                    <div class="relative">
                                                                        <select name="default-select"
                                                                        class="boatType-type w-full appearance-none rounded-lg border border-stroke bg-transparent py-3 pl-5 pr-12 text-dark outline-hidden focus:border-primary ">
                                                                        <option value="60" class="text-red-600" selected="<?php if ($p->get_ship()->get_type()->get_type() == 60):?>selected<?php endif; ?>"><strong>Passenger</strong></option>
                                                                        <option value="70" class="text-lime-600" selected="<?php if ($p->get_ship()->get_type()->get_type() == 70):?>selected<?php endif; ?>"><strong>Cargo</strong></option>
                                                                        <option value="80" class="text-sky-600" selected="<?php if ($p->get_ship()->get_type()->get_type() == 80):?>selected<?php endif; ?>"><strong>Tanker</strong></option>
                                                                        </select>
                                                                        <input type="text" class="hidden boatType-mmsi" value="<?=$p->get_ship()->get_mmsi()?>" />
                                                                        <span
                                                                        class="pointer-events-none absolute right-0 top-0 flex h-full w-12 items-center justify-center text-dark-5">
                                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                            d="M2.29645 5.15354L2.29642 5.15357L2.30065 5.1577L7.65065 10.3827L8.00167 10.7255L8.35105 10.381L13.7011 5.10603L13.7011 5.10604L13.7036 5.10354C13.7221 5.08499 13.7386 5.08124 13.75 5.08124C13.7614 5.08124 13.7779 5.08499 13.7964 5.10354C13.815 5.12209 13.8188 5.13859 13.8188 5.14999C13.8188 5.1612 13.8151 5.17734 13.7974 5.19552L8.04956 10.8433L8.04955 10.8433L8.04645 10.8464C8.01604 10.8768 7.99596 10.8921 7.98519 10.8992C7.97756 10.8983 7.97267 10.8968 7.96862 10.8952C7.96236 10.8929 7.94954 10.887 7.92882 10.8721L2.20263 5.2455C2.18488 5.22733 2.18125 5.2112 2.18125 5.19999C2.18125 5.18859 2.18501 5.17209 2.20355 5.15354C2.2221 5.13499 2.2386 5.13124 2.25 5.13124C2.2614 5.13124 2.2779 5.13499 2.29645 5.15354Z"
                                                                            fill="currentColor" stroke="currentColor" />
                                                                        </svg>
                                                                        </span>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="w-1/4">
                                                                <button type="button"
                                                                        class="change-type w-full text-white font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-800">
                                                                    Modify
                                                                </button>
                                                            </div>
                                                        </div>
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
                                                                <input type="number" id="timestamp-<?=$p->get_ship()->get_mmsi()?>" name="timestamp"
                                                                    class="input-timestamp w-full pr-12 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                                                    min="1" step="1" required
                                                                    placeholder="Duration"
                                                                />
                                                                <input type="text" class="hidden trajectory-id" value="<?=$p->get_id()?>" />
                                                                <span class="absolute inset-y-0 right-3 flex items-center text-gray-500 text-sm">
                                                                    min
                                                                </span>
                                                            </div>
                                                            <div class="w-1/4">
                                                                <button type="button"
                                                                        class="predict-trajectory w-full text-white font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-800">
                                                                    Predict
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- Pred answer -->
                                                        <div class="mt-6 pred-answer hidden">
                                                            <span class=" inline-block h-1 w-[90px] rounded-sm bg-blue-500"></span>                                    <p class="mb-10 text-base leading-relaxed text-body-color">
                                                            <p class="pred-text">Your ship is predicted to be at POS after X minutes</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php require "pages/footer.php" ?>

        </div>
    </body>
</html>