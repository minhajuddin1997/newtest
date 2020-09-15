const mutations={
    auth:(state,payload)=>{
        state.authCheck = payload.status;
        state.auth = payload.auth;
    },
    selectedCompany:(state,payload)=>{
        state.exchangeRequest.selectedCompany=payload;
    },
    receiveRequests:(state,payload)=>{
        state.exchangeRequest.receiveRequests=payload;
    },
    exchangeProcessDetails:(state,payload)=>{
        state.exchangeProcess.sender=payload.sender;
        state.exchangeProcess.requestedServices=payload.requestedServices;
        state.exchangeProcess.offerServices=payload.offerServices;
        state.exchangeProcess.amount=payload.amount;
        state.exchangeProcess.paidTo=payload.paidTo;
        state.exchangeProcess.paidBy=payload.paidBy;
    }
};

export {mutations};
