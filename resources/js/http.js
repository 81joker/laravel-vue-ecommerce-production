export function request(method, url, data = {}) {
    return fetch(url, {
        method,
        headers: {
            "Content-Type": "application/json",
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        // body: JSON.stringify(data),
        ...(method === 'GET' ? {} : {body: JSON.stringify(data)})
    }).then(async res =>{
        if (res.status > 200 && res.status < 300) {
            return res.json()
        }
        return await res.json()
    })
}


export function get(url){
    return request('GET', url)

}
export function post(url , data){
    return request('POST', url, data)
}
