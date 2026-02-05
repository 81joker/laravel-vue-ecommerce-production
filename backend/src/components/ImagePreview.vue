<template>
    <div>
        <div class="flex flex-wrap gap-1">
            <div
                v-for="(image) in imageUrl"
                :key="image"
                class="relative w-[120px] h-[120px] bg-gray-200 rounded-lg border flex items-center justify-center border-dashed overflow-hidden hover:border-purple-500 hover:bg-gray-100 cursor-pointer"
            >
                <img :src="image.url" class="w-full h-full object-cover" :class="image.deleted ? 'opacity-50' : ''" />
                <small v-if="image.deleted"
                 class="absolute left-0 bottom-0 right-0 py-1 px-2 bg-black w-100 text-white justify-between items-center flex">
                    To be deleted
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 cursor-pointer" @click="revertImage(image)">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/>
                    </svg>
                 </small>
                <span class="absolute top-1 right-1 cursor-pointer bg-red-500 text-white rounded-full p-1" @click="deleteImage(image)">
                    X
        <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
          <path
            d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
        </svg> -->
      </span>
            </div>
        </div>
        <div
            class="mt-2 relative w-[120px] h-[120px] bg-gray-200 rounded-lg border flex items-center justify-center border-dashed overflow-hidden hover:border-purple-500 hover:bg-gray-100 cursor-pointer"
        >
            <span> Upload </span>
            <input
                type="file"
                @change="onFileChange"
                accept="image/*"
                class="absolute left-0 top-0 bottom-0 right-0 w-full h-full"
            />
        </div>
    </div>
</template>
<script setup>
// Import
import { ref, onMounted, watch } from "vue";
import { v4 as uuidv4 } from "uuid";


// Refe
const files = ref([]);
const imageUrl = ref([]);
const deletedImages = ref([]);

// Props
const props = defineProps(["modelValue" , "deletedImages" , "images"]);
const emit = defineEmits(["update:modelValue" , "update:deletedImages" ]);


// Methods
function onFileChange(e) {
    files.value = [...files.value, ...e.target.files];
    for (let file of e.target.files) {
        file.id = uuidv4();        
        readFile(file).then((url) => {
            imageUrl.value.push({ 
                id: file.id, 
                url 
            });
        });
    }
    emit("update:modelValue", files.value);
}

function readFile(file) {
    return new Promise((resolve, reject) => {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        fileReader.onload = (e) => {
            resolve(e.target.result);
        };
        fileReader.onerror = (e) => {
            reject(e);
        };
    });
}

function deleteImage(image) {
    if (image.isProp) {
        // console.log("Image is from props" ,image.id);
        deletedImages.value.push(image.id);
        image.deleted = true;
        emit("update:deletedImages", deletedImages.value);
      } else {
        //  (°___°)   // This is the First(1) way to delete the image
        files.value = files.value.filter((file) => file.id !== image.id);
        imageUrl.value = imageUrl.value.filter((img) => img.id !== image.id);
        emit("update:modelValue", files.value);
    }

   // (°___°)   // This is the Second(2) way to delete the image
    // const index = imageUrl.value.findIndex((img) => img.id === image.id);
    // if (index !== -1) {
    //     imageUrl.value.splice(index, 1);
    //     files.value.splice(index, 1);
    //     emit("update:modelValue", files.value);
    // }
}

 // (°___°)// This is the Third(3) way to delete the image
// /////  This funtion also is very helpful to delete the image /////////////////
//  function deleteImage(index) {
//      imageUrl.value.splice(index, 1);
//      files.value.splice(index, 1);
//      emit('update:modelValue', files.value);
//  }

//  HOOk
watch('props.images' , () => {
    // console.log("Image is from watch" ,props.images);
    if('props.images' !== undefined){
        imageUrl.value = [
             ...imageUrl.value , 
             ...props.images.map( imageItem =>
              ({ ...imageItem , isProp: true }))  // Convert array of strings to array of objects with id and url properties
        ]
     }
    //  console.log("Image is from watch" ,imageUrl.value);

} , { immediate: true , deep: true });

onMounted(() => {
    emit("update:modelValue", []);
    emit("update:deletedImages", deletedImages.value);
});
</script>