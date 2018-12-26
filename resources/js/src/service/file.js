import { servicePost } from './base'
import { API_URI } from './config'

export function serviceImgAdd(image, type, thenCallback, failCallBack) {
    let params = new FormData();
    params.append('image', image);
    params.append('type', type);
    servicePost(API_URI.fileUploadImg, params, (res) => {
        thenCallback(res);
    }, (err) => {
        failCallBack(err);
    }, {'Content-Type': 'multipart/form-data'});
}