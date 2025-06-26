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