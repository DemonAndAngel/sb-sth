export const HOST = process.env.NODE_ENV === 'development'?'http://sb-sth.com/':'http://caideyu.top/';
export const API_BASE_URI = process.env.NODE_ENV === 'development'?'http://sb-sth.com/api/':'http://caideyu.top/api/';

export const WEB_URI = {
    index:HOST,
    postList:HOST+'post',
    postEdit:HOST+'post/edit',
    userLogin:HOST+'user/login',
    userRegister:HOST+'user/register',
};
export const API_URI = {
    userLogin:API_BASE_URI+'user/login',
    userRegister:API_BASE_URI+'user/register',
    userLogout:API_BASE_URI+'user/logout',

    fileUploadImg:API_BASE_URI+'file/upload/img',
    postGetList:API_BASE_URI+'post/get/list',
    postRelease:API_BASE_URI+'post/release',
    postDraft:API_BASE_URI+'post/draft',
};