//------------------------------------------------------------------------------
//--- ajaxRequest --------------------------------------------------------------
//------------------------------------------------------------------------------
// Perform an Ajax request.
// \param type The type of the request (GET, DELETE, POST, PUT).
// \param url The url with the data.
// \param callback The callback to call where the request is successful.
// \param data The data associated with the request.
/**
 * Perform an AJAX request to the specified URL
 * @param type - Request's verb (GET, POST, PUT, DELETE, UPDATE)
 * @param url - The destination URL
 * @param callback - The function which will treat the returned data's from the backend
 * @param data - Specific data to append at the end of the URL (POST/GET arguments)
 */
function ajaxRequest(type, url, callback, data = null, sendFile = false)
{
    let xhr;
    console.log(url + "?" + data);

    // Create XML HTTP request.
    xhr = new XMLHttpRequest();
    if (type == 'GET' && data != null)
        url += '?' + data;
    xhr.open(type, url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('Cache-Control', 'no-cache');
    xhr.setRequestHeader('Pragma', 'no-cache');

    if (sendFile) {
        xhr.setRequestHeader('X-File-Name', data.name);
        xhr.setRequestHeader('X-File-Size', data.size);
    }

    // Add the onload function.
    xhr.onload = () =>
    {
        switch (xhr.status)
        {
            case 200:
            case 201:
                console.log(xhr.responseText);
                callback(JSON.parse(xhr.responseText));
                break;
            default:
                console.log("default switch hit");
        }
    };

    // Send XML HTTP request.
    xhr.send(data);
}
//------------------------------------------------------------------------------
//--- Notification handler --------------------------------------------------------------
//------------------------------------------------------------------------------

    function handlerNotification(data) {
    const type = data.message;

    const messages = {
    success: {
    iconColor: 'text-green-200',
    bgColor: 'bg-green-800',
},
    error: {
    iconColor: 'text-red-200',
    bgColor: 'bg-red-800',
},
    warning: {
    iconColor: 'text-orange-200',
    bgColor: 'bg-orange-700',
}
};

    if (!messages[data.type]) return;

    const msg = messages[data.type];

    const toast = document.createElement('div');
    toast.className = `
      fixed z-[10] right-4 bottom-4 
      translate-y-10 opacity-0
      transition-all duration-300 ease-out
      flex items-center w-full max-w-xs p-4 mb-4 
      text-gray-400 ${msg.bgColor} rounded-lg shadow-sm
      pointer-events-auto
      
    `.trim();

    toast.innerHTML = `
      <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 ${msg.iconColor} ${msg.bgColor} rounded-lg">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="${getIconPath(type)}" />
        </svg>
      </div>
      <div class="ms-3 text-sm font-normal">${data.message}</div>
      <button type="button" class="ms-auto -mx-1.5 -my-1.5 ${msg.bgColor} text-gray-500 hover:text-white rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-700 inline-flex items-center justify-center h-8 w-8" aria-label="Close">
        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
      </button>
    `;

    document.body.appendChild(toast);

    requestAnimationFrame(() => {
    toast.classList.remove("translate-y-10", "opacity-0");
    toast.classList.add("translate-y-0", "opacity-100");
});

    const timeout = setTimeout(() => hideToast(), 5000);

    function hideToast() {
    toast.classList.remove("translate-y-0", "opacity-100");
    toast.classList.add("translate-y-10", "opacity-0");
    setTimeout(() => toast.remove(), 300);
}

    toast.querySelector('button').addEventListener('click', () => {
    clearTimeout(timeout);
    hideToast();
});
}

    function getIconPath(type) {
    switch (type) {
    case 'success':
    return 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z';
    case 'error':
    return 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z';
    case 'warning':
    return 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z';
    default:
    return '';
}
}


