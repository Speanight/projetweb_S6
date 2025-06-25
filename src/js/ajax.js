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
                httpErrors(xhr.status);
        }
    };

    // Send XML HTTP request.
    xhr.send(data);
}