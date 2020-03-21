<template>
    <div class="scrollbar-outer">
        <div class="container actionForm" v-if='actionForm'>
            <!-- onsubmit="return false;" -->
            <div class="sidebar-image col-12">
                <div class="insertLocation float-right">
                    <i class="fas fa-times closeForm" @click='closeForm'></i>
                </div>
            </div>
            <!-- onsubmit="return false;" -->
           <form method='POST' id='createForm' enctype="multipart/form-data" onsubmit="return false;">
                
                <input type="hidden" id='tit_loc' name='_token' :value='csrf' >
                
                <div class="sidebar-thumbnails col-12" style='height:auto'>
                    <ul class="thumbnails scrollbar-outer" v-if='previewImages'>
                        <li
                        v-for='(image, id) in previewImages'
                        :key='id'
                        @click='seeImageForm(image)'
                        ><img :src="image" alt="" class='img-fluid'>
                        <i class="fas fa-times deleteImg" @click='removePreviewImage(image)'></i>
                       </li>
                    </ul>
                </div>
                <div class="from-group">
                    <label for="exampleInputEmail1">Картинки</label>
                    <input type="file" id="file" name='image_url[]' ref="myFiles" 
                     multiple @change="previewFiles">
                     <!--  -->
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Заголовок</label>
                    <input type="text" id='title' v-model='title' name='title' class="form-control" placeholder="Введіть.....">
                </div>
                    <div class="form-group">
                    <label for="exampleFormControlTextarea1">Опис</label>
                    <textarea v-model='textarea' id='textarea' class="form-control" name='text' rows="3"></textarea>
                </div>
                <input type="hidden" name='marker' :value='JSON.stringify(this.marker)'>
                <button type="submit" v-if='createquery' @click='createQuery()' class="btn btn-primary">Створити</button>
                <button type="submit" v-if='insertquery' @click='insertQuery()' class="btn btn-primary">Створити</button>
                <!-- @click='createQuery()' -->
                <!-- @click='insertQuery()' -->
            </form>
        </div>
        <div class="informationLocation" v-else>
            <div class="sidebar-image col-12">
                <div class="insertLocation float-right" v-if='contentUser'>
                    <i class="fas fa-pen" @click='insertData'></i>
                    <i class="fas fa-trash" @click='removeData(data.id)'></i>
                </div>
            </div>
            <div class="sidebar-thumbnails col-12" >
                <ul class="thumbnails scrollbar-outer" v-if='imagesUrl'>
                    <li
                    v-for='(image, id) in imagesUrl'
                    :key='id'
                    @click='seeImage(image)'
                    ><img :src="'/storage/'+image['image_url']" alt="" class='img-fluid'></li>
                </ul>
            </div>
            <div class="sidebar-title">
                <h3 class='text-center' v-if='data != null'>{{data['title']}}</h3>    
            </div>
            <div class="sidebar-text col-12">
                <p class="text-justify" v-if='data != null'>
                    {{data['text']}}
                </p>
            </div>
            <div class="sidebar-comment container">
                <div class="comment-header">
                    <h4 class="title">
                        Коментарії:
                    </h4>
                </div>
                <div class="form-comment" v-if='userId'>
                    <!-- onsubmit="return false;" -->
                    <form onsubmit="return false;">
               
                        <div class="form-group">
                            <textarea v-model='review' name='review' class="form-control" id="comment-text" rows="3"></textarea>
                        </div>
                        <button @click='createComment' type="submit" class="btn btn-outline-secondary btn-sm float-right">Коментувати</button>
                    </form>
                </div>
                <p class='empty-comment' v-if='comments == null'>Коментарів немає(((</p>
                <div class="comment-body">
                    <div class="row user-comment" v-for='user in comments' :key='user.id'>
                        <div class="col-12">
                            <div class="card card-white post">
                                <div class="post-heading">
                                    <div class="float-left user-image ">
                                        <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar" alt="user profile image" width="50">
                                    </div>
                                    <div class="float-left user-info row">
                                        <div class="title col-12">
                                            <h6>{{user.surname}}</h6>
                                        </div>
                                        <div class="time col-12">
                                            <p class="text-muted float-left small">{{user.updated_at.substring(0,10)}}</p>
                                            <p class="text-muted float-left small ml-2">{{user.updated_at.substring(11,16)}}</p>
                                        </div>
                                    </div>
                                </div> 
                                <div class="post-description text-justify"> 
                                    <p>{{user.review}}</p>
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
   export default {
        props:[
            'data',
            'marker',
            'imagesUrl',
            'comments',
            'userId',
            'activForm',
            'creatForm'
        ],
        data() {
            return {
                file:null,
                title:null,
                textarea:null,
                newImages:[],
                previewImages:[],
                removeImages:[],
                imageScr:'',
                csrf:$('meta[name="csrf-token"]').attr('content'),
                contentUser:'false',
                actionForm:false,
                review:null,
                inputFiles:null,
                markerPosition:null,
                createquery:false,
                insertquery:false,
            }
        },
        async beforeRouteEnter(to,from,next){
            let res = await getData();
            next(vm => {
            vm.imagesUrl = res.data;
            });
        },
        methods: {
            seeImage: function(e) {
                $('.sidebar-image').css('background-image','url("storage/'+e['image_url']+'")');
                
            },
            seeImageForm: function(e) {
                $('.sidebar-image').css('background-image','url("'+e?e:''+'")');
            },
           async createQuery() {
               

                let vue = this;
                if(this.inputFiles != null) {
                    for( let item of this.inputFiles) {
                        await this.uploadsFile(item);
                    }
                }
                axios
                .post('/user',{
                    title:this.title,
                    text:this.textarea,
                    marker:JSON.stringify(this.marker),
                    image_url:this.newImages
                })
                .then(function(data) {
                    $('.sidebar').removeClass('active');
                    vue.$emit('location',data.data);
                    $('.sidebar-image').css('background-image','url("")');
                    vue.closeForm();
                });
                this.createquery = false;
                $('.sidebar').removeClass('active');
            },
            async previewFiles(e) {
                this.inputFiles = Array.from(event.target.files);

                var file = e.target.files; 
                for (var i = 0, f; f = file[i]; i++) {

                    if (!f.type.match('image.*')) {
                        alert("Image only please....");
                    }
                    var reader = new FileReader();
                    var vue = this.previewImages;
                    reader.onload = (function (theFile) {
                        return function (e) {
                        vue.push(e.target.result);	
                        };
                    })(f);
                    reader.readAsDataURL(f);
                } 
            },
            async uploadsFile(item){
                let vue = this;
                let form = new FormData();
                form.append('image',item);
                await axios.post('/user/upload',form)
                .then(function(data){
                    vue.newImages.push(data.data);
                })
                .catch(error => {console.log(error)});
            },
            insertData: function(e) {
                this.$emit('insertform');
                alert('Insert');
                this.createquery = false;
                this.insertquery = true;
                this.title = this.data.title;
                this.textarea = this.data.text;
                this.imagesUrl.forEach(el => {
                    this.previewImages.push('/storage/' +el.image_url);
                })
                this.seeImageForm(this.previewImages[0]);
                this.actionForm = true;
            },
            async insertQuery(e) {
  
                let vue = this;
                if(this.inputFiles != null) {
                    for( let item of this.inputFiles) {
                        await this.uploadsFile(item);
                    }
                }  
                axios
                .put('/user/'+this.data.id,{
                    title:this.title,
                    text:this.textarea,
                    image_url:this.newImages,
                    old_image_url:this.removeImages
                })
                .then(function(data) {
                    alert('success');
                    $('.sidebar').removeClass('active');
                    $('.sidebar-image').css('background-image','url("")');
                    vue.closeForm();
                    // vue.$emit('location',data.data);
                });
                
                $('.sidebar').removeClass('active');
            },
            removeData: function(e) {
                this.$emit('removeloc',e);
            },
            closeForm:function() {
                $('.sidebar').removeClass('active');
                document.querySelectorAll('input, textarea').forEach(el=>el.value = '');

                // this.actionForm = false;
                this.$emit('actform',this.createquery);
                this.inputFiles = [];
                this.newImages = [];
                this.title = null;
                this.textarea = null;
                this.previewImages = [];
            },
            createComment: function(e) {
                axios
                .post('/user',{
                    location_id:this.data.id,
                    review:this.review
                })
                .then(function(data) {
                    $('.user-comment').before(
                        $('<div/>').attr('class','row user-comment').append(
                            $('<div/>').attr('class','col-12').append(
                                $('<div/>').attr('class','card card-white post').append(
                                    $('<div/>').addClass('post-heading').append(
                                        $('<div/>').attr('class','float-left user-image').append(
                                            $('<img/>').attr({
                                                src:'http://bootdey.com/img/Content/user_1.jpg',
                                                class:'img-circle avatar',
                                                width:'50'
                                            })
                                        ),
                                        $('<div/>').attr('class','float-left user-info row').append(
                                            $('<div/>').attr('class','title col-12').append(
                                                $('<h6/>').text(data.data.surname)
                                            ),
                                            $('<div/>').attr('class','time col-12').append(
                                                $('<p/>').attr('class','text-muted float-left small')
                                                .text(data.data.updated_at.substr(0,10)),
                                                $('<p/>').attr('class','text-muted float-left small ml-2')
                                                .text(data.data.updated_at.substr(11,5))
                                            )
                                        )
                                    ),
                                    $('<div/>').attr('class','post-description text-justify').append(
                                        $('<p/>').text(data.data.review)
                                    )
                                )
                            )
                        )
                    );
                });
            },
            removePreviewImage:function(e) {
                for (let index = 0; index < this.previewImages.length; index++) { 
                    console.log(this.previewImages[index] + ' == '+  e);
                    if(this.previewImages[index] == e) {
                        this.previewImages.splice(index,1);
                        this.removeImages.push(e.substr(9));
                    }
                }
            }
        },
        watch: {
            data:function() {
                $('.sidebar').addClass('active');
                // console.log(this.data.user_id +' == '+ this.userId);
                
                if(this.data.user_id == this.userId) {
                    this.contentUser = true;
                }else {
                    this.contentUser = false;
                }
                if(this.imagesUrl.length != 0) {
                    $('.sidebar-image').css('background-image','url("storage/'+this.imagesUrl[0]['image_url']+'")');
                }else{
                    $('.sidebar-image').css('background-image','url("")');
                }
            },
            previewImages:function() {
                if(this.previewImages.length != 0) {
                    $('.sidebar-image').css('background-image','url("'+this.previewImages[0]+'")');
                }else{
                    $('.sidebar-image').css('background-image','url("")');
                }
            },
            activForm:function() {
                this.markerPosition = this.marker;
                this.actionForm = this.activForm;
            },
            creatForm:function() {
                 this.createquery = true;
                this.insertquery = false;
            }
        }
    }

</script>
