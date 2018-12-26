import {serviceGet, servicePost} from './base'
import {API_URI} from './config'

export function servicePostList(is_self,thenCallback, failCallBack) {
    serviceGet(API_URI.postGetList, {is_self:is_self}, (res) => {
        thenCallback(res);
    }, (err) => {
        failCallBack(err);
    });
}

export function servicePostRelease(post_id, thenCallback, failCallBack) {
    let params = {post_id:post_id};
    servicePost(API_URI.postRelease, params, (res) => {
        thenCallback(res);
    }, (err) => {
        failCallBack(err);
    }, {'Content-Type': 'application/json'});
}

export function servicePostDraft(post_id, title, content, thenCallback, failCallBack) {
    let params = {post_id: post_id, title: title, content: content};
    servicePost(API_URI.postDraft, params, (res) => {
        thenCallback(res);
    }, (err) => {
        failCallBack(err);
    }, {'Content-Type': 'application/json'});
}

