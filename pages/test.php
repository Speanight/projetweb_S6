<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title> index </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="/src/js/ajax.js" defer></script>
    </head>

<link href="src/css/test.css" rel="stylesheet" type="text/css" />
<body>
<div id="wrap">
      <header x-data="
        {
          navbarOpen: false
        }
      " class="flex w-full items-center bg-[#E2F3FA]/40 ">
    <div class="container mx-auto">
      <div class="relative -mx-4 flex items-center justify-center">
        <div class="w-full px-4">
            <nav :class="!navbarOpen && 'hidden' " id="navbarCollapse"
              class="flex justify-center items-center w-full rounded-lg bg-white px-6 shadow lg:static lg:block lg:w-full lg:shadow-none mt-2 mb-2">
              <ul class="block lg:flex">
                <div class ="flex flex-row items-center">
                  <li>
                    <img src="assets/logo.jpg" alt="logo" width="69" height="69" />
                  </li>
                  <li>
                    <a
                    lass="flex py-2 text-lg font-bold text-body-color hover:text-dark lg:ml-12 lg:inline-flex">
                    Titan'ISEN
                    </a>
                  </li>
                
                <li>
                  <a href="/accueil"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex">
                    Home Page
                  </a>
                </li>
                <li>
                  <a href="/boat"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex">
                    Add your own boat
                  </a>
                </li>
                <li>
                  <a href="/maps"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex">
                    Tracking
                  </a>
                </li>
                <li>
                  <a href="/about"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex">
                    About our Project
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex">
                    <input type="search" placeholder ="	&#x1F50D Search" class="border rounded-lg px-2 py-1 bg-[#1B44C8]/30">
                  </a>
                </li>
                </div>
              </ul>
            </nav>
          </div>
        </div>
      </div>
  </header>

    <div id="body">
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
        <h1>Test</h1>
    </div>
</body>

  <footer class="relative z-10 bg-white pt-5">
    <div class="bg-linear-[90deg,#ecfeff_5%,white_12%,white_88%,#ecfeff] ">
      <div class="mx-[12%] flex flex-wrap">
        <div class="w-full lg:w-[20%] -ml-6">
          <div class="w-full">
            <a class="mb-6 flex flex-row flex-wrap items-center">
              <img src="assets/logo.jpg" alt="logo" class="max-w-full basis-auto w-[69px]" />
              <p class="font-roboto font-bold basis-auto text-[26px]">Titan'ISEN</p>
            </a>
            <p class="mb-7 text-base text-body-color text-slate-400">
              We are an independent team using recent technologies and AI to help visualize and optimize boats trajectories.
            </p>
            <p class="flex items-center text-sm font-medium text-dark">
            </p>
          </div>
        </div>
        <div class="w-full px-4 lg:w-[13%]">
          <div class="w-full">
            <h4 class="mb-9 text-lg font-semibold text-dark ">
              Resources
            </h4>
            <ul class="space-y-1">
              <li>
                <a href="javascript:void(0)"
                  class="inline-block text-base leading-loose text-body-color hover:text-slate-400 text-slate-600 whitespace-nowrap">
                  Our boats database
                </a>
              </li>
              <li>
                <a href="/about"
                  class="inline-block text-base leading-loose text-body-color hover:text-slate-400 text-slate-600 whitespace-nowrap">
                  Learn more
                </a>
              </li>
              <li>
                <a href="javascript:void(0)"
                  class="inline-block text-base leading-loose text-body-color hover:text-slate-400 text-slate-600 whitespace-nowrap">
                  Our AI researches
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="w-full px-4 lg:w-[13%]">
          <div class="w-full ml-6">
            <h4 class="mb-9 text-lg font-semibold text-dark ">
              Quick links
            </h4>
            <ul class="space-y-1">
              <li>
                <a href="/accueil"
                  class="inline-block text-base leading-loose text-body-color hover:text-slate-400 text-slate-600 whitespace-nowrap">
                  Home page
                </a>
              </li>
              <li>
                <a href="/boat"
                  class="inline-block text-base leading-loose text-body-color hover:text-slate-400 text-slate-600 whitespace-nowrap">
                  Add your own entry
                </a>
              </li>
              <li>
                <a href="/maps"
                  class="inline-block text-base leading-loose text-body-color hover:text-slate-400 text-slate-600 whitespace-nowrap">
                  Map of boats
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="w-full px-4 lg:w-3/20 min-w-[160px]">
          <div class="w-full ml-10">
            <h4 class="mb-9 text-lg font-semibold text-dark">
              Follow Us On
            </h4>
            <div class="mb-6 flex items-center">
              <a class="mr-3 flex h-8 w-8 items-center justify-center rounded-full border border-stroke text-dark hover:border-primary hover:text-slate-400 sm:mr-4 lg:mr-3 xl:mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
              </a>
              <a class="mr-3 flex h-8 w-8 items-center justify-center rounded-full border border-stroke text-dark hover:border-primary hover:bg-primary hover:text-slate-400 sm:mr-4 lg:mr-3 xl:mr-4 ">
                <span width="16" height="12" viewBox="0 0 16 12" class="fill-current material-symbols-outlined">commit</span>
              </a>
              <a class="mr-3 flex h-8 w-8 items-center justify-center rounded-full border border-stroke text-dark hover:border-primary hover:bg-primary hover:text-slate-400 sm:mr-4 lg:mr-3 xl:mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>
              </a>
            </div>
            <p class="text-base text-body-color text-slate-600 whitespace-nowrap">
              &copy; 2025 ISEN Nantes
            </p>
          </div>
        </div>
        <div class="w-full px-4 sm:w-auto min-w-[10%] ml-6">
            <img src="assets/ISEN.jpeg" />
        </div>
      </div>
    </div>
  </footer>

</div>