<template>
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-log card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">add</i>
                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <h4 class="card-title">Añadir nuevo libro</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <b-form @submit.prevent="add">
                                        <b-row>
                                            <b-col cols="4">
                                                <label for="isbn">ISBN</label>
                                                <b-form-input type="text" v-model="book.isbn" id="isbn" name="isbn" placeholder="Tip: el ISBN tiene 13 caracteres"></b-form-input>
                                                <b-form-invalid-feedback :state="validateISBN">El código ISBN es numérico entero debe 13 caracteres</b-form-invalid-feedback>
                                            </b-col>

                                            <b-col cols="4">
                                                <label for="titulo_ori">Título Original</label>
                                                <b-form-input type="text" v-model="book.titulo_ori" id="titulo_ori" name="titulo_ori" placeholder="Título original"></b-form-input>
                                                <b-form-invalid-feedback :state="validateTO">El título no puede estar vacío</b-form-invalid-feedback>
                                            </b-col>

                                            <b-col cols="4">
                                                <label for="titulo_esp">Título en Español</label>
                                                <b-form-input type="text" v-model="book.titulo_esp" id="titulo_esp" name="titulo_esp" placeholder="Título en español"></b-form-input>
                                                <b-form-invalid-feedback :state="validateTE">El título no puede estar vacío</b-form-invalid-feedback>
                                            </b-col>
                                        </b-row>
                                        <br>
                                        <b-row>
                                            <b-col cols="6">
                                                <label for="tema_princ">Tema principal</label>
                                                <b-form-textarea type="text" v-model="book.tema_princ" id="tema_princ" placeholder="Tema principal" name="tema_princ"></b-form-textarea>
                                            </b-col>

                                        </b-row>
                                        <hr>
                                        <b-row>
                                            <b-col cols="12">
                                                <label for="sinop">Sinopsis</label>
                                                <b-form-textarea v-model="book.sinop" size="lg" rows="8" id="sinop" name="sinop" placeholder="Sinopsis"></b-form-textarea>
                                                <b-form-invalid-feedback :state="validateSinopsis">La sinopsis debe ser al menos de 10 caracteres</b-form-invalid-feedback>
                                            </b-col>
                                        </b-row>
                                        <hr>
                                        <b-row>
                                            <b-col cols="4">
                                                <label for="n_pag">Número de páginas</label>
                                                <b-form-input v-model="book.n_pag" id="n_pag" name="n_pag" placeholder="Número de páginas"></b-form-input>
                                                <b-form-invalid-feedback :state="validateNP">El número de páginas debe ser numérico entero</b-form-invalid-feedback>
                                            </b-col>

                                            <b-col cols="4">
                                                <label for="fec_pub">Fecha de publicación</label>
                                                <b-form-input type="date" v-model="book.fec_pub" id="fec_pub" name="fec_pub"></b-form-input>
                                                <b-form-invalid-feedback :state="validateF">* Requerido</b-form-invalid-feedback>
                                            </b-col>

                                            <b-col cols="4">
                                                <label for="editorial">Editorial</label>
                                                <b-form-select v-model="book.editorial" :options="editoriales" id="editorial" name="editorial"></b-form-select>
                                                <b-form-invalid-feedback :state="validateE">* Requerido</b-form-invalid-feedback>
                                            </b-col>
                                        </b-row>
                                        <br>
                                        <b-row>
                                            <b-col cols="4">
                                                <label for="autor">Autor</label>
                                                <b-form-input v-model="book.autor" id="autor" name="autor" placeholder="Autor"></b-form-input>
                                                <b-form-invalid-feedback :state="validateA">El autor no puede estar vacío</b-form-invalid-feedback>
                                            </b-col>

                                            <b-col cols="4">
                                                <label for="id_prev">ISBN Predecesor</label>
                                                <b-form-input v-model="book.prev" id="id_prev" name="id_prev" placeholder="ISBN"></b-form-input>
                                                <b-form-invalid-feedback :state="validateP">El ISBN no puede ser el del mismo libro y tiene que ser un ISBN válido</b-form-invalid-feedback>
                                            </b-col>
                                        </b-row>
                                        
                                        <hr>

                                        <b-row>
                                            <b-col cols="6">
                                                <h6><strong>GÉNEROS Y SUBGÉNEROS</strong></h6>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col cols="6">
                                                <label for="genero">Genero</label>
                                                <b-form-select v-model="book.genero" :options="generos" @change="filter()" id="genero" name="genero"></b-form-select>
                                                <b-form-invalid-feedback :state="validateG">* Requerido</b-form-invalid-feedback>
                                            </b-col>

                                            <b-col cols="6">
                                                <label for="subg">Subgenero</label>
                                                <b-form-select v-model="book.subg" :options="subgeneros" id="subg" name="subg"></b-form-select>
                                                <b-form-invalid-feedback :state="validateSG">* Requerido</b-form-invalid-feedback>
                                            </b-col>

                                        </b-row>
                                        <br>
                                        <div class="d-flex flex-row-reverse bd-highlight">
                                            <b-button variant="default" @click="revalidate">Continuar</b-button>
                                        </div>
                                    </b-form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
    data() {
        return {
            book: {
                isbn: '',
                titulo_ori: '',
                titulo_esp: '',
                tema_princ: '',
                sinop: '',
                n_pag: null,
                subg: null,
                fec_pub: null,
                editorial: null,
                autor: '',
                prev: '',
                genero: null,

            },
            generos: [{
                value: null,
                text: 'Seleccionar'
            }],
            subgenerosfiltered: [{}],
            subgeneros: [{
                value: null,
                text: 'Seleccionar'
            }],
            libros: [{}],
            librosfiltered: [{}],
            subgbackup: [{}],
            librosbackup: [{}],
            editoriales: [{}],
        }
    },

    created() {
        axios.get('/books/create')
            .then(res => {
                this.editoriales = res.data.data;
                this.generos = res.data.genres;
                this.subgbackup = res.data.sg;
                this.libros = res.data.prev;

                //console.log (this.libros.findIndex(isbn => isbn.isbn === 21354)!=-1);
            }).catch(e => {
                console.log(e);
            })
    },

    computed: {
        validateISBN(){
            let isValid = null;
                if (this.book.isbn=='' || this.book.isbn == null) return null;
                if (this.book.isbn.toString().length == 13 && !isNaN(this.book.isbn) && this.book.isbn.indexOf(".")==-1 && this.book.isbn>0)
                return true;
                else return false;
        },
        validateTO(){
            if (this.book.titulo_ori=='' || this.book.titulo_ori == null) return null;
            if (this.book.titulo_ori.length > 40) return false;
            else return true; 
        },
        validateTE(){
            if (this.book.titulo_esp=='' || this.book.titulo_esp == null) return null;
            if (this.book.titulo_esp.length > 40) return false;
            else return true;
        },
        validateSinopsis(){
            if (this.book.sinop == '' || this.book.sinop == null) return null;
            if (this.book.sinop.length > 1000 ||this.book.sinop.length < 9) return false;
            else return true;
        },
        validateNP(){
            let isValid = null;
            if (this.book.n_pag == null || this.book.n_pag == '') return null;
                if (this.book.n_pag!=null && (isNaN(this.book.n_pag) || this.book.n_pag.indexOf(".")!=-1 || this.book.n_pag<0 || this.book.n_pag > 999999)) isValid = false;
                else isValid = true;
            return isValid;
        },
        validateF(){
            return (this.book.fec_pub != null);
        },
        validateA(){
            if (this.book.autor =='' && this.book.autor == null) return null;
            if (this.book.autor.length > 50) return false;
            else return true;
        },
        validateG(){
            return(this.book.genero != null);
        },
        validateSG(){
            return(this.book.subg != null);
        },
        validateE(){
            return(this.book.editorial != null);
        },
        validateP(){
            let verif = (this.libros.findIndex(isbn => isbn.isbn == this.book.prev)!=-1);
            let validPrev=null;
                if (this.book.prev!='' && (this.book.prev.toString().length != 13 || isNaN(this.book.prev.isbn) || this.book.prev.indexOf(".")!=-1 || this.book.prev.isbn<0)) validPrev = false;
                else validPrev = true;
                if (this.book.prev == '')
                    return true;
            return ((this.book.prev != this.book.isbn && verif) || validPrev );

        }
    },
    methods: {
        convert(id, length) {
            let pos = id.indexOf("-");
            let res = id.substring(pos + 1, length);
            parseInt(res, 10);
            return res;
        },

        isBookInDB(){
            let verif = (this.libros.findIndex(isbn => isbn.isbn == this.book.isbn)!=-1);
            return verif;
        },

        filter() {
            /* Filter subgenres according to the genre*/
            this.subgeneros = [{}],
                this.subgenerosfiltered = [{}],
                this.book.subg = null,
                this.subgeneros = this.subgbackup;

            let i = 0;

            for (i = 0; i < this.subgeneros.length; i++) {
                /* Converted ID is id_sub*/
                let convertedid = this.convert(this.subgeneros[i].value, this.subgeneros.length);
                if (this.book.genero == convertedid) {
                    let actualid = this.subgeneros[i].value.substring(0, this.subgeneros[i].value.indexOf("-"));
                    actualid = parseInt(actualid, 10);
                    this.subgenerosfiltered.push({
                        value: actualid,
                        text: this.subgeneros[i].text
                    });
                }
            }

            this.subgeneros = [{}];
            this.subgeneros = this.subgenerosfiltered;

            this.subgeneros[0].value = null;
            this.subgeneros[0].text = 'Seleccionar';
        },

        

        revalidate(){
          let msg = '';
          let isValid = true;

            if (this.validateISBN == null) msg = msg + "El ISBN no puede estar vacío<br>";
            if (this.validateISBN == false) msg = msg + "El ISBN debe ser un campo numérico entero de 13 caracteres<br>";
            if (this.isBookInDB == true) msg = msg + "Libro con este ISBN ya existe en la base de datos<br>";
            if (this.validateTO == null) msg = msg + "El campo Título Original no puede estar vacío<br>";
            if (this.validateTO == false) msg = msg +  "El campo Título Original no puede estar vacío<br>";
            if (this.validateTE == null) msg = msg + "El campo Título en Español no puede estar vacío<br>";
            if (this.validateTE == false) msg = msg + "El campo Título en Español no puede tener más de 40 caracteres<br>";
            if (this.validateSinopsis == null) msg = msg + "El campo Sinopsis no puede estar vacío<br>";
            if (this.validateSinopsis == false) msg = msg + "El campo Sinopsis no puede tener más de 10 caracteres<br>";
            if (this.validateNP == null) msg = msg + "El campo Número de Páginas no puede estar vacío<br>";
            if (this.validateNP == false) msg = msg + "El campo número de páginas debe ser numérico entero<br>";
            if (this.validateF == false) msg = msg + "El campo Fecha de publicación no puede estar vacío<br>";
            if (this.book.editorial == null) msg = msg + "El campo Editorial no puede estar vacío<br>";
            if (this.book.genero == null) msg = msg + "El campo Genero no puede estar vacío<br>";
            if (this.book.genero != null && this.book.subg == null) msg = msg + "El campo Subgénro no puede estar vacío<br>";
            if (this.validateA == false ||this.validateA == null) msg = msg + "El campo Autor no puede estar vacío<br>";
            if (this.validateP == false) msg = msg + "En el campo libro predecesor debe haber un ISBN válido<br>";
            if (msg!=''){
                isValid = false;
                Swal.fire({
                    title: 'Error',
                    html: '<p class="text-left">'+msg+'</p>',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#8C7F7F',
                })
            }
            else {
                this.add();
            }
        },

        /* CRUD BOOKS */
        add() {
            const params = {
                isbn: this.book.isbn,
                titulo_ori: this.book.titulo_ori,
                titulo_esp: this.book.titulo_esp,
                tema_princ: this.book.tema_princ,
                sinop: this.book.sinop,
                autor: this.book.autor,
                n_pag: this.book.n_pag,
                genero: this.book.genero,
                subg: this.book.subg,
                fec_pub: this.book.fec_pub,
                prev: this.book.prev,
                editorial: this.book.editorial,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            };


            this.book.isbn = '';
            this.book.titulo_ori = '';
            this.book.tema_princ = '';
            this.book.titulo_esp = '';
            this.book.autor = '';
            this.book.n_pag = '';
            this.book.genero = '';
            this.book.subg = '';
            this.book.fec_pub = '';
            this.book.editorial = '';

            axios.post('/books', params)

                .then(res => {
                    window.location = "/books";
                }).catch(e => {
                    console.log(e);
                })
        },
    }
}
</script>

<style>

</style>
