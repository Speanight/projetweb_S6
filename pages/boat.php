<!DOCTYPE html>
<html lang="fr">
    <?php require_once "pages/head.php"; ?>
<script src="/src/js/boat.js" defer></script>

    <body class="h-screen bg-cover bg-no-repeat bg-blend-multiply bg-[#00122C]/50 backdrop-blur-sm"
    style="background-image: url('assets/bg add boat.jpg');">
        <div id="wrap">
            <?php require_once "pages/header.php"; ?>
            <div id="body" class="w-full p-8 backdrop-blur-sm flex flex-row gap-4 overflow-hidden">
                <div class="rounded-lg shadow-lg bg-[#F5F7FD]/25 flex flex-col w-full h-full p-6 text-white">
                    <h4 class="text-4xl font-extrabold mb-6">Enter your ship's features to enable tracking!</h4>
                    <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full h-full mb-6">

                        <!-- MMSI -->
                        <div>
                            <label for="mmsi" class="block mb-2 text-sm font-medium">MMSI</label>
                            <input type="text" id="mmsi" name="mmsi" placeholder="123456789"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium">Ship name</label>
                            <input type="text" id="name" name="name" placeholder="Titanic"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- Status dropdown -->
                        <div class="relative">
                            <label for="status" class="block mb-2 text-sm font-medium">Status</label>
                            <select id="status" name="status"
                                    class="appearance-none bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="1">Anchored</option>
                                <option value="2">Not under command</option>
                                <option value="3">Restricted Maneuverability</option>
                                <option value="5">Moored</option>
                                <option value="6">Aground</option>
                                <option value="7">Engaged in fishing</option>
                                <option value="8">Under way sailing</option>
                                <option value="14">SART / MOB/ EPIRB</option>
                                <option value="15">Undefined</option>

                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="block mb-2 text-sm font-medium">Latitude</label>
                            <input type="number" step="any" id="latitude" name="latitude" placeholder="42.12345"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- Longitude -->
                        <div>
                            <label for="longitude" class="block mb-2 text-sm font-medium">Longitude</label>
                            <input type="number" step="any" id="longitude" name="longitude" placeholder="-71.98765"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- Timestamp -->
                        <div>
                            <label for="timestamp" class="block mb-2 text-sm font-medium">Timestamp</label>
                            <input type="datetime-local" id="timestamp" name="timestamp"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- SOG -->
                        <div>
                            <label for="sog" class="block mb-2 text-sm font-medium">Speed over ground (SOG)</label>
                            <input type="number" step="any" id="sog" name="sog" placeholder="12.5"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- COG -->
                        <div>
                            <label for="cog" class="block mb-2 text-sm font-medium">Course over ground (COG)</label>
                            <input type="number" step="any" id="cog" name="cog" placeholder="85.3"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- Heading -->
                        <div>
                            <label for="heading" class="block mb-2 text-sm font-medium">True Heading</label>
                            <input type="number" step="any" id="heading" name="heading" placeholder="90.0"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- Length -->
                        <div>
                            <label for="length" class="block mb-2 text-sm font-medium">Length (m)</label>
                            <input type="number" step="any" id="length" name="length" placeholder="100.0"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- Width -->
                        <div>
                            <label for="width" class="block mb-2 text-sm font-medium">Width (m)</label>
                            <input type="number" step="any" id="width" name="width" placeholder="20.0"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <!-- Draft -->
                        <div>
                            <label for="draft" class="block mb-2 text-sm font-medium">Draft (m)</label>
                            <input type="number" step="any" id="draft" name="draft" placeholder="6.5"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>
                    </form>
                    <button class="group relative h-12 overflow-hidden overflow-x-hidden rounded-md bg-neutral-950 px-8 py-2 text-neutral-50"><span class="relative z-10">Add ship</span><span class="absolute inset-0 overflow-hidden rounded-md"><span class="absolute left-0 aspect-square w-full origin-center -translate-x-full rounded-full bg-green-500 transition-all duration-500 group-hover:-translate-x-0 group-hover:scale-150"></span></span></button>
                </div>


                <div class="rounded-lg shadow-lg bg-[#F5F7FD]/25 flex flex-col w-full h-full p-6 text-white gap-6 overflow-y-auto">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl p-4 shadow flex flex-col gap-2 text-gray-900">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">Ships tracked</p>
                                    <p id="numShipsTracked" class="text-2xl font-bold">795</p>
                                </div>
                                <!--
                                <div class="text-sm text-red-500 font-semibold flex items-center gap-1">
                                    <span>1.39%</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                                -->
                            </div>
                            <div class="w-full h-1 bg-orange-400 rounded"></div>
                        </div>


                        <div class="bg-white rounded-xl p-4 shadow flex flex-col gap-2 text-gray-900">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">Ships docked</p>
                                    <p id="numShipsDocked" class="text-2xl font-bold">573</p>
                                </div>
                                <!--
                                <div class="text-sm text-green-600 font-semibold flex items-center gap-1">
                                    <span>2.69%</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" /></svg>
                                </div>
                                -->
                            </div>
                            <div class="w-full h-1 bg-purple-400 rounded"></div>
                        </div>
                    </div>

                    <div id="shipContainer" class="flex flex-col gap-4">
                        <h2 class="text-xl font-bold text-white">Discover some ships !</h2>

                    </div>
                </div>
            </div>

            <?php require_once "pages/footer.php"; ?>
        </div>
    </body>
</html>
