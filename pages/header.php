<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title> index </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="/src/js/ajax.js" defer></script>
    </head>
  <header x-data="
        {
          navbarOpen: false
        }
      " class="flex w-full items-center dark:bg-dark bg-[#E2F3FA]/40 ">
    <div class="container mx-auto">
      <div class="relative -mx-4 flex items-center justify-center">
        <div class="w-full px-4">
            <nav :class="!navbarOpen && 'hidden' " id="navbarCollapse"
              class="flex justify-center items-center w-full rounded-lg bg-white px-6 shadow lg:static lg:block lg:w-full lg:shadow-none dark:bg-dark-2 lg:dark:bg-transparent mt-2 mb-2">
              <ul class="block lg:flex">
                <div class ="flex flex-row items-center">
                  <li>
                    <a href="javascript:void(0)">
                    <img src="assets/logo.jpg" alt="logo" class="dark:hidden" width="69" height="69" />
                    </a>
                  </li>
                  <li>
                    <a href="javascript:void(0)"
                    lass="flex py-2 text-lg font-bold text-body-color hover:text-dark lg:ml-12 lg:inline-flex dark:text-dark-6 dark:hover:text-white">
                    Titan'ISEN
                    </a>
                  </li>
                
                <li>
                  <a href="/accueil"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex dark:text-dark-6 dark:hover:text-white">
                    Home Page
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex dark:text-dark-6 dark:hover:text-white">
                    Add your own boat
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex dark:text-dark-6 dark:hover:text-white">
                    Tracking
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex dark:text-dark-6 dark:hover:text-white">
                    About our Project
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)"
                    class="flex py-2 text-base font-medium text-body-color hover:text-dark lg:ml-12 lg:inline-flex dark:text-dark-6 dark:hover:text-white">
                    <input type="search" placeholder ="Search" class="border rounded-lg px-2 py-1">
                  </a>
                </li>
                </div>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </header>

