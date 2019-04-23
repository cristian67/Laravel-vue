   
   @extends('main')
   @section('content')    
        <template v-if="menu==0">
        
        </template>
        
        <template v-if="menu==1">
                <Categoria></Categoria>
        </template>
        
        <template v-if="menu==2">
                <Articulo></Articulo>
        </template>

        <template v-if="menu==3">
                <h1>"contenido menu 3"</h1>
        </template>
        <template v-if="menu==4">
                <Proveedor></Proveedor>
        </template>
        <template v-if="menu==5">
                <h1>"contenido menu 5"</h1>
        </template>
        <template v-if="menu==6">
                <Cliente></Cliente>
        </template>
        <template v-if="menu==7">
                <h1>"contenido menu 7"</h1>
        </template>
        <template v-if="menu==8">
                <h1>"contenido menu 8"</h1>
        </template>
        <template v-if="menu==9">
                <h1>"contenido menu 9"</h1>
        </template>
        <template v-if="menu==10">
                <h1>"contenido menu 10"</h1>
        </template>
        <template v-if="menu==11">
                <h1>"contenido menu 11"</h1>
        </template>
        <template v-if="menu==12">
                <h1>"contenido menu 12"</h1>
        </template>
   @endsection
