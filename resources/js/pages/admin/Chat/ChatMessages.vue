<template>
    <main>
        <div class="container-fluid p-0">
            <div class="row col-12 p-0" >
                <div class="p-0"  id="messages-container" style="height: 670px; min-width: 100%; overflow-y: auto">
                    <div v-if="!messages.length & loading" class="d-flex justify-content-center"><span style="height: 40px; width: 40px;" class="spinner-border text-danger text-center"></span> </div>
                    <div style="max-width: 30%;" v-if="!messages.length & !loading" class="p-2 sender pull-6">
                        <p>No Messages</p>
                    </div>
                    <div style="width: 60%;margin: 4px;" v-for="message in messages" v-if="messages.length"  :class="auth.user.id===message.fromId?'pull-right':'pull-left'">
                        <img v-show="auth.user.id!==message.fromId" :src="auth.user.id!==message.fromId?asset+message.profile_picture:asset+auth.user.profile_picture" style="height: 50px; width: 50px; float:left; margin-left: 5%;" class="img-fluid img-circle" />
                        <p :class="auth.user.id!==message.fromId?'receiver p-3':'sender p-3'" :style="{width:'84%',float: 'right',
                        borderRadius:auth.user.id!==message.fromId?'15px 15px 15px 0px':'15px 15px 0px 15px'}">{{message.message}}</p>
                        <br>
                    </div>

                </div>
            </div>
        </div>
    </main>
</template>


<script>
    export default {
        name:'ChatMessages',
        props:['asset','auth','messages','loading'],
        data:function(){
            return {
                objDiv: {}
            }
        },
        mounted() {
                this.objDiv=document.getElementById("messages-container");
                this.objDiv.scrollTop = this.objDiv.scrollHeight;
        },
        updated() {

                this.objDiv.scrollTop = this.objDiv.scrollHeight;
        }
    }
</script>
