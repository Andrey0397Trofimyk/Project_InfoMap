
<template>
	<div class="map">
		<GmapMap
			:center="center"
			:zoom="7"
			map-type-id="terrain"
			@click="onMapClick($event)"
			ref=map
			>
			<GmapMarker
				:key="index"
				v-for="(m, index) in markers"
				:position="m.position"
				:clickable="true"
				:draggable="false"
				:animation=2
				:label='m.id'
				ref=mark
				@click="onMarkerClick(m.position,infoLocation['id'],$event)"
			/>
		</GmapMap>
			<button v-if='userId' @click='createMarker' class='createMarker float-right'>
			<i class="fas fa-plus "></i>
		</button>
	</div>
</template>
<script>
	export default {
		name: "App",
		props:{
		infoLocation:null,
		userId:null,
		newLocation:null,
		deleteMarker:null,
		actionForm:null
		},
		data: () => ({
		center:{lat:51.1518032,lng:23.6378023},
		markers: [],
		markerId: null,
		accessCreate: false,
		}),
		methods: {
			createMarker(e){
				// this.$emit('closeWindow');
				
				$('.sidebar').removeClass('active');
				this.accessCreate = true;
			},
			onMapClick(e) {
				// console.log(new google.maps.LatLng( e.latLng ));
				// console.log(number(e.latLng));
				console.log(e.latLng.lat())
                console.log(e.latLng.lng())
				if(this.accessCreate && !this.actionForm) {
					this.markers.push({
						position: e.latLng
					});
					this.markerId=e.latLng;
					this.center = e.latLng;
					this.$emit('form',e.latLng);
					this.accessCreate = false;
					$('.sidebar').addClass('active');
				}else {
					if(this.actionForm == true) {
						alert('Ви не зберегли зміни!!!');
					}else {
						$('.sidebar').removeClass('active');
					}
				}
			},
			onMarkerClick(e,i,m_p) {
				console.log(m_p.latLng.lat());
                console.log(m_p.latLng.lng());
				this.accessCreate = false;
				this.center = {
					lat: e.lat ,
					lng: e.lng 
				}
				this.infoLocation.forEach(element => {
					if(element['marker'] == '{"lat":'+e.lat+',"lng":'+e.lng+'}') {
						
						this.markerId = element['id'];
						this.$emit('position',element['id']);
					}
						// for (let index = 0; index < this.newLocation.length; index++) {
						// 	// const element = array[index];
						// 	console.log(element['marker'] + ' ||| ' +this.newLocation[index]['marker']);
						// 	if(element['marker'] == '{"lat":'+e.lat+',"lng":'+e.lng+'}' || element['marker'] == this.newLocation[index]['marker']) {
						// 	console.log('+');
						// 	alert('openLocation');
						// 	this.markerId = element['id'];
						// 	// this.$emit('position',element['id']);
						// 	}	
						// }
				})
			}
		},
		watch:{
			newLocation:function() {
				this.newLocation.forEach(element => {
					this.infoLocation.push(element);
				});
				// this.infoLocation.push(this.newLocation);
			},
			deleteMarker: function() {

				for (let index = 0; index < this.markers.length; index++) {
					if(JSON.stringify(this.markers[index].position) == this.deleteMarker) {
						alert();
						 this.markers.splice(index, 1);
					}
				}
			},
			actionForm: function() {
				if(this.actionForm == false) {
					this.markers.pop();
				}	
			}
		},
		mounted() {
			this.infoLocation.forEach((element) => {
				this.markers.push({
					position: JSON.parse(element['marker'])
				})
			});
		}
	};
</script>