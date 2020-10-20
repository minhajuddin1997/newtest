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
        state.exchangeProcess.selectedServices=payload.selectedServices;
        state.exchangeProcess.amount=payload.amount;
        state.exchangeProcess.paidTo=payload.paidTo;
        state.exchangeProcess.paidBy=payload.paidBy;
        state.exchangeProcess.requestId=payload.requestId;
    }
};

export {mutations};
