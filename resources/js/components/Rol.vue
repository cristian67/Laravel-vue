<template>
    <main class="main">
         <!-- Breadcrumb -->
         <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
         </ol>
         <div class="container-fluid">
             <!-- Ejemplo de tabla Listado -->
             <div class="card">
                 <div class="card-header">
                     <i class="fa fa-align-justify"></i> Rol
                 </div>
                 <div class="card-body">
                     <div class="form-group row">
                         <div class="col-md-6">
                             <div class="input-group">
                                 <select class="form-control col-md-3" v-model="criterio">
                                   <option value="nombre">Nombre</option>
                                   <option value="descripcion">Descripción</option>
                                 </select>
                                 <input type="text" v-model="buscar" @keyup.enter="listRol(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                 <button type="submit" @click="listRol(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                             </div>
                         </div>
                     </div>
                     <table class="table table-bordered table-striped table-sm">
                         <thead>
                             <tr>
                                 <th>Nombre</th>
                                 <th>Descripción</th>
                                 <th>Estado</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr v-for = "rol in arrayRol" :key = "rol.id">
                                 <td v-text="rol.nombre"></td>
                                 <td v-text="rol.descripcion"></td>
                                 <td>
                                   <div v-if="rol.condicion">
                                     <span class="badge badge-success">Activo</span>
                                   </div>
                                   <div v-else>
                                     <span class="badge badge-danger">Desactivado</span>
                                   </div>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                     <nav>
                         <ul class="pagination">
                             <li class="page-item" v-if="pagination.current_page > 1">
                                 <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                             </li>
                             <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active':'']">
                                 <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"> </a>
                             </li>                         
                             <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                 <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)" >Sig</a> 
                             </li>
                         </ul>
                     </nav>
                 </div>
             </div>
             <!-- Fin ejemplo de tabla Listado -->
         </div>
     </main>
</template>

<script>

export default {
    
    data(){
      return {
        rol_id: 0,
        nombre: '',
        descripcion: '',
        arrayRol: [],
        modal: 0,
        tituloModal: '',
        tipoAccion: 0,
        pagination: {
                
            'total':0,
            'current_page':0,
            'per_page': 0,
            'last_page':0,
            'from':0,
            'to':0   
        },
        offset: 3, 
        criterio: 'nombre',
        buscar: ''
      }   
    },

    //Propiedad Computada
    computed: {
        
        isActived: function(){
            return this.pagination.current_page;
        },

        pagesNumber: function (){
            if(!this.pagination.to)
            {
                return [];
            }

            var from = this.pagination.current_page - this.offset;
            if(from<1)
            {
                from = 1;      
            }

            var to = from + (this.offset * 2);
            if(to >= this.pagination.last_page)
            {
                to=this.pagination.last_page;
            }

            var pagesArray = [];
            while(from<=to)
            {
                pagesArray.push(from);
                from++;
            }

            return pagesArray;
        } 
    },

    //Funciones    
    methods: {
        listRol(page, buscar, criterio){
            let me  = this;
            var url = '/rol?page='+page+'&buscar='+buscar+'&criterio='+criterio; 
                axios.get(url)  
                            .then(function (response) {
                                var resp = response.data; 
                                me.arrayRol = resp.roles.data;
                                me.pagination = resp.pagination;
                                console.log(response.data);
                                })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                                })
                            .then(function () {
                            // always executed
                });
        },

        cambiarPagina(page, buscar, criterio){
            let me = this;
            me.pagination.current_page = page;
            me.listRol(page, buscar, criterio);
        }
    },
    //Funcion pre-determinada con la data cargada
    mounted() {
           this.listRol(1,this.buscar,this.criterio);
    } 
}
</script>


<style>
    .modal-content{
        width: 100% !important;
        position: absolute;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important; 

    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red;
        font-weight: bold;
    }
</style>

