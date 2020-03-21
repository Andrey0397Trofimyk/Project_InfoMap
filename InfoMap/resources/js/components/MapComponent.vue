
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
		// App
		name: "Map",
		props:{
		infoLocation:null,
		userId:null,
		newLocation:null,
		deleteMarker:null,
		actionForm:null,
		newMarker:false
		},
		data: () => ({
		center:{lat:51.1518032,lng:23.6378023},
		markers: [],
		markerId: null,
		accessCreate: false,
		locations:[]
		}),
		methods: {
			// freate marker
			createMarker(e){
				$('.sidebar').removeClass('active');
				this.accessCreate = true;
				this.$emit('createform');
				// this.newMarker = true;
			},
			// function map click
			onMapClick(e) {
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
			// function marker click
			onMarkerClick(e,i,m_p) {
				this.accessCreate = false;
				this.center = {
					lat: e.lat ,
					lng: e.lng 
				}
				console.log(this.newLocation.length);
				this.infoLocation.forEach(element => {
					
						if(element['marker'] == '{"lat":'+m_p.latLng.lat()+',"lng":'+m_p.latLng.lng()+'}') {
							this.markerId = element['id'];
							this.$emit('position',element['id']);
						}


					// if(this.newLocation.length == 0) {
						
					// 	if(element['marker'] == '{"lat":'+m_p.latLng.lat()+',"lng":'+m_p.latLng.lng()+'}') {
					// 		this.markerId = element['id'];
					// 		this.$emit('position',element['id']);
					// 	}
					// } else{
						
					// 	for (let index = 0; index < this.newLocation.length; index++) {
					// 		if(element['marker'] == '{"lat":'+m_p.latLng.lat()+',"lng":'+m_p.latLng.lng()+'}') {
					// 		this.markerId = element['id'];
					// 		this.$emit('position',element['id']);
					// 		}	
					// 	}
					// }
				})

			}
		},
		watch:{
			// add new location to list
			newLocation:function() {
				this.locations.push(this.newLocation);
				// this.newLocation.forEach(element => {
				// 	this.infoLocation.push(element);
				// });
				this.infoLocation.push(this.newLocation);
			},
			// drop marker
			deleteMarker: function() {
				alert();
				for (let index = 0; index < this.markers.length; index++) {
					if(JSON.stringify(this.markers[index].position) == this.deleteMarker) {
						 this.markers.splice(index, 1);
					}
				}
			},
			actionForm: function() {

				if(this.newMarker == true) {
					this.markers.pop();
					this.$emit('removemark');
				}	
			}
		},
		// add marker to map
		mounted() {
			this.locations = [];
			this.locations = this.infoLocation;
			this.infoLocation.forEach((element) => {
				this.markers.push({
					position: JSON.parse(element['marker'])
				})
			});
		}
	};
</script>