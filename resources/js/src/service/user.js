import {serviceGet, servicePost} from './base'
import {API_URI} from './config'

export function serviceUserLogin(account, password, thenCallback, failCallBack) {
    let params = {account: account, password: password};
    servicePost(API_URI.userLogin, params, (res) => {
        thenCallback(res);
    }, (err) => {
        failCallBack(err);
    }, {'Content-Type': 'application/json'});
}

export function serviceUserRegister(account, password, nickname, thenCallback, failCallBack) {
    let params = {account: account, password: password, nickname: nickname};
    servicePost(API_URI.userRegister, params, (res) => {
        thenCallback(res);
    }, (err) => {
        failCallBack(err);
    }, {'Content-Type': 'application/json'});
}

export function serviceUserLogout(thenCallback, failCallBack) {
    servicePost(API_URI.userLogout,{}, (res) => {
        thenCallback(res);
    }, (err) => {
        failCallBack(err);
    }, {'Content-Type': 'application/json'});
}
