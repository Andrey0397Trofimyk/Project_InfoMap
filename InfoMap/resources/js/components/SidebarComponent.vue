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
           <form method='POST' action='/user' id='createForm' enctype="multipart/form-data" onsubmit="return false;">
                <input type="hidden" id='tit_loc' name='_token' :value='csrf' >
                
                <div class="sidebar-thumbnails col-12" style='height:auto'>
                    <ul class="thumbnails scrollbar-outer" v-if='previewImages'>
                        <li
                        v-for='(image, id) in previewImages'
                        :key='id'
                        @click='seeImage(image)'
                        ><img :src="image" alt="" class='img-fluid'>
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
                    <input type="text" v-model='title' name='title' class="form-control" placeholder="Введіть.....">
                </div>
                    <div class="form-group">
                    <label for="exampleFormControlTextarea1">Опис</label>
                    <textarea v-model='textarea' class="form-control" name='text' rows="3"></textarea>
                </div>
                <input type="hidden" name='marker' :value='JSON.stringify(this.marker)'>
                <button type="submit" @click='createQuery()' class="btn btn-primary">Створити</button>
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
                    <form method='POST' action='/user' onsubmit="return false;">
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
        ],
        data() {
            return {
                images:['lubart_1.jpg'], 
                file:null,
                title:null,
                textarea:null,
                newImages:[],
                previewImages:[],
                imageScr:'',
                csrf:$('meta[name="csrf-token"]').attr('content'),
                contentUser:'false',
                actionForm:false,
                review:null,
                inputFiles:null
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
                // $('thumbnails img[src="'+'/storage/'+e['image_url']+'"').css('border','1px solid black');
                console.log($(e.target));
            },
           async createQuery() {

                let vue = this;
                // let files = Array.from($('#file').files);        
                for( let item of this.inputFiles) {
                    await this.uploadsFile(item);
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
                });

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
                alert();
                // $('input[name="title"]').val(this.data.title);
                // $('textarea[name="text"]').text(this.data.text);
                // $('input[name="marker"]').val(this.data.marker);
                $('input[name="title"]').val('замок Любарта');
                $('textarea[name="text"]').text('вімвімвімві');
                // $('input[name="marker"]').val(this.data.marker);
                // this.previewImages = this.imagesUrl;
                // this.previewImages
                this.actionForm = true;
            },
            removeData: function(e) {
                this.$emit('removeloc',e);
            },
            closeForm:function() {
                $('.sidebar').removeClass('active');
                document.querySelectorAll('input, textarea').forEach(el=>el.value = '');
                this.actionForm = false;
                this.$emit('actform');

            },
            createComment: function(e) {
                // axios
                // .post('/user',{
                //     location_id:this.data.id,
                //     review:this.review
                // })
                // .then(function(data) {
                //     alert('success');
                // });
            }
        },
        watch: {
            data:function() {
                $('.sidebar').addClass('active');
                console.log(this.data.user_id +' == '+ this.userId);
                if(this.data.user_id == this.userId) {
                    this.contentUser = true;
                }else {
                    this.contentUser = false;
                }
                if(this.imagesUrl) {
                    $('.sidebar-image').css('background-image','url("storage/'+this.imagesUrl[0]['image_url']+'")');
                }
            },
            previewImages:function() {
                 $('.sidebar-image').css('background-image','url("'+this.previewImages[0]+'")');
            },
            activForm:function() {
                this.actionForm = this.activForm;
            }
        }
    }

</script>
