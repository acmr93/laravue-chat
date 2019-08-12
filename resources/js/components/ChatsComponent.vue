<template>
    <div class="row">
        <div class="col-8">
            <div class="card card-default">
                <div class="card-header">Mensajes</div>
                <div class="card-body">
                    <ul class="list-unstyled" style="height: 300px; overflow-y: scroll;">
                        <li class="p-2" v-for="(mensaje, index) in mensajes" :key="index" >
                            <strong> {{mensaje.user.name}} </strong>
                            {{mensaje.valor}}
                        </li>
                        
                    </ul>
                </div>
                <input 
                    @keyup.enter="EnviarMensajes"
                    v-model="NuevoMensaje"
                    type="text="
                    class="form-control"
                    name="mensaje"
                    placeholder="Escriba su mensaje...">
            </div>
                <span class="text-muted">Fulanito esta escribiendo</span>
        </div>
        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Usuarios Conectados</div>
                <div class="card-body">
                    <ul>
                        <li class="py-2">Angela</li>
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
                NuevoMensaje: ''
            }
        },

        created () {
            this.ObtenerMensajes();
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
            }
        }

    }


</script>
