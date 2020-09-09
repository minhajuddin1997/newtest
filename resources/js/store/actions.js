import {logout} from "../helpers/helpers";
const actions={
    logout:(context,email)=>{
        return new Promise((resolve, reject)=>{
            logout(email).then((response)=>{
                localStorage.removeItem('authToken');
                context.commit('auth',{status:false,auth:{}});
                resolve();
            }).catch((error)=>{
                reject(error);
            })
        });
    },
    viewSearchedCompany:(context,company)=>{
        context.commit('selectedCompany',company);
    },
    setReceiveRequests:(context,requests)=>{
        context.commit('receiveRequests',requests);
    },
    setSendRequests:(context,requests)=>{
        context.commit('sendRequests',requests);
    }
};

export {actions};
