import {prefixPath, redirectedPaths} from "../helpers";

const authorize=function(to,from,next){
    const auth=JSON.parse(localStorage.getItem('authToken'));
    if(auth){
        var authToken=auth.token;
        var expire=new Date(auth.expire);
        var now=new Date();
    }
    if(authToken!='' && (expire>now)){
        next();
    }else{
        localStorage.removeItem('authToken');
        window.location.href=redirectedPaths('/login',prefixPath);
    }
};

const isNotAuthorize=function(to, from, next){
    const auth=JSON.parse(localStorage.getItem('authToken'));
    if(auth){
        var authToken=auth.token;
        var expire=new Date(auth.expire);
        var now=new Date();
    }
    if(!authToken || (expire<now)){
        localStorage.removeItem('authToken');
        next();
    }else{
        //dashboard
        window.location.href=redirectedPaths('/admin',prefixPath);
    }
};

const adminMiddleware=(to,from,next)=>{
    const auth=JSON.parse(localStorage.getItem('authToken'));
    if(!auth){
        window.location.href=redirectedPaths('/login',prefixPath);
    }
    else if(auth.user.role_id==1){
        next();
    }else {
        next({name:'admin'});
    }
};

export {authorize, isNotAuthorize, adminMiddleware};
