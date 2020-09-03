<template>
    <main>

        <div class="container-fluid">
            <div class="row col-12 p-0">
                    <div class="input-group mb-3 chat-form">
                        <input type="text" class="form-control" placeholder="Enter a message" v-model="message">
                        <div class="input-group-append">
                            <button class="btn" type="button" v-on:click="sendMessage"><i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>
            </div>
        </div>

    </main>
</template>
<script>
    export default{
        name:'ChatForm',
        data:function(){
          return{
              message:''
          }
        },
        methods:{
            sendMessage:function () {
                if(this.message===''){
                    swal("Stop","Write something before sending it.",'error');
                }
                this.$emit('send',this.message);
                this.message='';
            }
        }
    }
</script>
