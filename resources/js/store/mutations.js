const mutations={
    auth:(state,payload)=>{
        state.authCheck = payload.status;
        state.auth = payload.auth;
    }
};

export {mutations};
