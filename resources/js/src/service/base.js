export function serviceGet(url, params, thenCallback, failCallBack, headers) {
    if (!headers) {
        headers = {};
    }
    axios({
        url: url,
        method: 'get',
        data: params,
        headers: headers,
    }).then((res) => {
        thenCallback(res);
    }).catch((err) => {
        failCallBack(err);
    })
}

export function servicePost(url, params, thenCallback, failCallBack, headers) {
    if (!headers) {
        headers = {};
    }
    axios({
        url: url,
        method: 'post',
        data: params,
        headers: headers,
    }).then((res) => {
        thenCallback(res);
    }).catch((err) => {
        failCallBack(err);
    })
}
