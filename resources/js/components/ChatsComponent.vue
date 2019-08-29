<template>
    <div class="row">
        <div class="col-8">
            <div class="card card-default">
                <div class="card-header">Mensajes</div>
                <div class="card-body">
                    <ul class="list-unstyled" style="height: 300px; overflow-y: scroll;" v-chat-scroll >
                        <li class="p-2" v-for="(mensaje, index) in mensajes" :key="index" >
                            <strong> {{mensaje.user.name}} </strong>
                            {{mensaje.valor}}
                        </li>
                        
                    </ul>
                </div>
                <input 
                    @keydown="sendTypingEvent"
                    @keyup.enter="EnviarMensajes"
                    v-model="NuevoMensaje"
                    type="text="
                    class="form-control"
                    name="mensaje"
                    placeholder="Escriba su mensaje...">
            </div>
                <span class="text-muted" v-if="usuarioActivo"> {{ usuarioActivo }} esta escribiendo </span>
        </div>
        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Usuarios Conectados</div>
                <div class="card-body">
                    <ul>
                        <li class="py-2" v-for="(user, index) in users" :key="index">
                            {{user.name}}
                        </li>
                    </ul>
                </div>
                
            </div>
            
        </div>
    </div>
</template>

<script>
    export default {

        props: ['user'],

        data() {
            return {
                mensajes: [], 
                NuevoMensaje: '',
                users: [],
                usuarioActivo: false,
                susurro:'',
                timeOut: false
            }
        },

        created () {
            this.ObtenerMensajes();

            Echo.join('CanalChat')
                .here( user => {
                    this.users = user;
                })
                .joining( user => {
                    this.users.push(user)
                })
                .leaving( user => {
                    this.users = this.users.filter( u => u.id != user.id )
                })
                .listen('MensajeEnviado', (event) => {
                    this.mensajes.push(event.mensaje);
                })
                .listenForWhisper('probando', user => {
                    this.usuarioActivo = user.name;

                    if (this.timeOut) {
                        clearTimeout(this.timeOut);
                    }

                    this.timeOut = setTimeout( () => {
                        this.usuarioActivo = false;
                    }, 300);
                })
        },

        methods: {
            ObtenerMensajes() {
                axios.get('mensajes').then( response =>{
                    this.mensajes = response.data;
                })  
            },

            EnviarMensajes() {

                this.mensajes.push({
                    user: this.user,
                    valor: this.NuevoMensaje
                }); 

                axios.post('mensajes', {valor: this.NuevoMensaje});

                this.NuevoMensaje = '';
            },

            sendTypingEvent(){
                Echo.join('CanalChat').whisper('probando', this.user);
            }
        }

    }


</script>
