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
                     <i class="fa fa-align-justify"></i> Articulos
                     <button type="button" 
                             class="btn btn-secondary" 
                             @click="abrirModal('articulo','registrar')">
                         <i class="icon-plus"></i>&nbsp;Nuevo
                     </button>
                 </div>
                 <div class="card-body">
                     <div class="form-group row">
                         <div class="col-md-6">
                             <div class="input-group">
                                 <select class="form-control col-md-3" v-model="criterio">
                                   <option value="nombre">Nombre</option>
                                   <option value="descripcion">Descripción</option>
                                 </select>
                                 <input type="text" v-model="buscar" @keyup.enter="listArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                 <button type="submit" @click="listArticulo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                             </div>
                         </div>
                     </div>
                     <table class="table table-bordered table-striped table-sm">
                         <thead>
                             <tr>
                                 <th>Opciones</th>
                                 
                                 <th>Codigo</th>
                                 <th>Nombre</th>
                                 <th>Categoria</th>
                                 <th>Precio Venta</th>
                                 <th>Stock</th>
                                 <th>Descripción</th>
                                 <th>Estado</th>
                             </tr>
                         </thead>
                         <tbody>
                             <tr v-for = "articulo in arrayArticulo" :key = "articulo.id">
                                 <td>
                                     <button type="button" 
                                             class="btn btn-warning btn-sm"
                                             @click="abrirModal('articulo','actualizar',articulo)">
                                       <i class="icon-pencil"></i>
                                     </button> &nbsp;
                                     <template v-if="articulo.condicion">
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm"
                                                    @click="desactivarArticulo(articulo.id)" >
                                                    <i class="icon-trash"></i>
                                            </button>
                                     </template>  
                                     <template v-else>
                                            <button type="button" 
                                                    class="btn btn-info btn-sm"
                                                    @click="activarArticulo(articulo.id)" >
                                                    <i class="icon-check"></i>                                            
                                            </button>
                                     </template>
                                 </td>
                                 <td v-text="articulo.codigo"></td>
                                 <td v-text="articulo.nombre"></td>                                                               
                                 <td v-text="articulo.categoria"></td>
                                 <td v-text="articulo.precio_venta"></td>
                                 <td v-text="articulo.stock"></td>
                                 <td v-text="articulo.descripcion"></td>
                                 <td>
                                   <div v-if="articulo.condicion">
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
         <!--Inicio del modal agregar/actualizar-->
         <div :class="{'mostrar': modal}" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
             <div class="modal-dialog modal-primary modal-lg" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h4 class="modal-title" v-text="tituloModal"></h4>
                         <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                           <span aria-hidden="true">×</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            
                            <div class="form-group row">
                                 <label class="col-md-3 form-control-label" for="text-input">Categoria</label>
                                 <div class="col-md-9">
                                     <select class="form-control" v-model="idcategoria">
                                        <option value="0" disabled>Selección</option>
                                        <option v-for="categoria in arrayCategoria" 
                                                :key="categoria.id" 
                                                :value="categoria.id" 
                                                v-text="categoria.nombre">
                                        </option>
                                     </select>
                                 </div>
                            </div>


                            <div class="form-group row">
                                 <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                 <div class="col-md-9">
                                     <input type="text" v-model="codigo"  class="form-control" placeholder="Ingrese código de barra">
                                     <barcode :value="codigo" :options="{format: 'EAN-13' }">
                                         Generando codigo de barras..
                                     </barcode>
                                 </div>
                            </div>

                            <div class="form-group row">
                                 <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                 <div class="col-md-9">
                                     <input type="text" v-model="nombre"  class="form-control" placeholder="Nombre de articulo">
                                 </div>
                            </div>


                            <div class="form-group row">
                                 <label class="col-md-3 form-control-label" for="text-input">Precio de venta</label>
                                 <div class="col-md-9">
                                     <input type="number" v-model="precio_venta"  class="form-control" placeholder="precio de venta">
                                 </div> 
                            </div>

                            
                            <div class="form-group row">
                                 <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                                 <div class="col-md-9">
                                     <input type="number" v-model="stock"  class="form-control" placeholder="stock">
                                 </div> 
                            </div>
                             
                            <div class="form-group row">
                                 <label class="col-md-3 form-control-label" for="email-input" >Descripción</label>
                                 <div class="col-md-9">
                                     <input type="email" v-model="descripcion" class="form-control" placeholder="Descripcion">
                                 </div>
                            </div>

                             <div v-show="errorArticulo" class="form-group row div-error">
                                 <div class="text-center text-error">
                                      <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error"> 
                                        
                                      </div>
                                 </div>
                             </div>
                         </form>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                         <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarArticulo()">Guardar</button>
                         <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()" >Actualizar</button>

                     </div>
                 </div>
                 <!-- /.modal-content -->
             </div>
             <!-- /.modal-dialog -->
         </div>
         <!--Fin del modal-->
     </main>
</template>

<script>
import VueBarcode from 'vue-barcode';
export default {
    
    data(){
      return {
        articulo_id: 0,
        idcategoria: 0,
        nombre_categoria: '',
        codigo: '',
        nombre: '',
        precio_venta:0,
        stock:0,
        descripcion: '',
        arrayArticulo: [],
        modal: 0,
        tituloModal: '',
        tipoAccion: 0,
        errorArticulo: 0,
        errorMostrarMsjArticulo : [],
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
        buscar: '',
        arrayCategoria:[]
      }   
    },

    components: {
        'barcode': VueBarcode
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
        listArticulo(page, buscar, criterio){
            let me  = this;
            var url = '/articulo?page='+page+'&buscar='+buscar+'&criterio='+criterio; 
                axios.get(url)  
                            .then(function (response) {
                                var resp = response.data; 
                                me.arrayArticulo = resp.articles.data;
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

        selectCategoria(){
            
            let me  = this;
            var url = '/categoria/selectCategoria'; 
                axios.get(url)  
                            .then(function (response) {
                                // console.log(response.data);
                                var resp = response.data; 
                                me.arrayCategoria = resp.categorias;
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
            me.listArticulo(page, buscar, criterio);
        },
    
        registrarArticulo(){
            
            if (this.validarArticulo()) 
            {
                return;    
            }
            
            let me = this;
            axios.post('/articulo/registrar', 
                       {
                           'idcategoria': this.idcategoria,
                           'codigo': this.codigo,
                           'nombre': this.nombre,
                           'precio_venta':this.precio_venta,
                           'stock': this.stock,
                           'descripcion': this.descripcion  
                       }).then( function (response) {
                           //Si todo sale bien se ejecuta cerrar y listar categoria  
                           me.cerrarModal();
                           me.listArticulo(1,'','nombre');
                       }).catch(function (error) {
                                    console.log(error);
            });
        },

      

        actualizarArticulo(){

            if (this.validarArticulo()) 
            {
                return;    
            }
            
            let me = this;
            axios.put('/articulo/actualizar', 
                       {
                           'idcategoria': this.idcategoria,
                           'codigo': this.codigo,
                           'nombre': this.nombre,
                           'precio_venta':this.precio_venta,
                           'stock': this.stock,
                           'descripcion': this.descripcion,
                           'id': this.articulo_id

                       }).then( function (response) {
                           //Si todo sale bien se ejecuta cerrar y listar categoria  
                           me.cerrarModal();
                           me.listArticulo(1,'','nombre');
                       }).catch(function (error) {
                                    console.log(error);
            });

        },

        validarArticulo(){
            this.errorArticulo = 0;
            this.errorMostrarMsjArticulo = [];

            if(this.idcategoria==0)
            {
                this.errorMostrarMsjArticulo.push("Selecciona una categoria");
            }
            
            if(!this.stock)
            {
                this.errorMostrarMsjArticulo.push("El stock no puede estar vacio");
            }
            
            
            if(!this.precio_venta)
            {
                this.errorMostrarMsjArticulo.push("El precio de venta  no puede estar vacio");
            }

            if (!this.nombre) 
            {
                this.errorMostrarMsjArticulo.push("El nombre no puede estar vacío!. ");    
            }

            if (this.errorMostrarMsjArticulo.length) 
            { 
                this.errorArticulo = 1;
            }

            return this.errorArticulo;
        },

        abrirModal(modelo,accion,data=[]){
            switch (modelo) 
            {
                case 'articulo':
                {
                    switch (accion) 
                    {
                        case 'registrar':
                            this.modal = 1;
                            this.tituloModal = 'Registrar articulo';
                            this.tipoAccion = 1;
                            this.idcategoria=0;
                            this.nombre_categoria='';
                            this.codigo='';
                            this.nombre = '';
                            this.precio_venta=0;
                            this.stock=0;
                            this.descripcion = '';
                         
                            break;
                        
                        case 'actualizar':
                            console.log(data);    
                            this.modal=1; 
                            this.tituloModal = 'Actualizar articulo';
                            this.tipoAccion = 2;
                            this.articulo_id = data['id'];
                            this.idcategoria= data['idcategoria'];
                            this.codigo=data['codigo'];
                            this.nombre = data['nombre'];
                            this.precio_venta=data['precio_venta'];
                            this.stock=data['stock'];
                            this.descripcion = data['descripcion'];
                            break;                       
                    }
                }
            }
            this.selectCategoria(); 
        },

        
        cerrarModal()
        {
            this.modal=0;
            this.tituloModal='';
            this.idcategoria=0;
            this.nombre_categoria='';
            this.codigo='';
            this.nombre='';
            this.precio_venta=0;
            this.stock=0;
            this.descripcion='';
            this.errorArticulo=0; 
        },

        desactivarArticulo(id){
            const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false,
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                    }).then((result) => {
                    if(result.value){
                        let me = this;
                        console.log(id);
                        axios.put('/articulo/desactivar',{
                                        'id': id
                                    }).then( function (response) {
                                        //Si todo sale bien se ejecuta cerrar y listar categoria  
                                        me.listArticulo(1,'','nombre');
                                        swalWithBootstrapButtons.fire(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                            )
                                    }).catch(function (error) {
                                                    console.log(error);
                                    });
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                        )
                    }
                    })  

        },

        activarArticulo(id){
        const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false,
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, activate it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                    }).then((result) => {
                    if(result.value){
                        let me = this;
                        console.log(id);
                        axios.put('/articulo/activar',{
                                        'id': id
                                    }).then( function (response) {
                                        //Si todo sale bien se ejecuta cerrar y listar categoria  
                                        me.listArticulo(1,'','nombre');
                                        swalWithBootstrapButtons.fire(
                                            'Activate!',
                                            'Your file has been activate.',
                                            'success'
                                            )
                                    }).catch(function (error) {
                                            console.log(error);
                                    });
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        'Cancelled'
                        )
                    } 
                    })  
        },

    },

    //Funcion pre-determinada con la data cargada
    mounted() {
           this.listArticulo(1,this.buscar,this.criterio);
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

