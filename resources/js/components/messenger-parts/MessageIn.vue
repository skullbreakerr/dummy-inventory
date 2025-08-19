<template>
  <div class="d-flex justify-content-start mb-10">
    <!--begin::Wrapper-->
    <div class="d-flex flex-column align-items-start">
      <!--begin::User-->
      <div class="d-flex align-items-center mb-2">
        <div class="symbol symbol-35px symbol-circle">
          <img alt="Pic" :src="image" />
        </div>

        <!--begin::Details-->
        <div class="ms-3">
          <span
            href="#"
            class="fs-5 fw-bold text-gray-900 text-hover-primary me-1"
            >{{ name }}</span
          >
          <span class="text-muted fs-7 mb-1">{{ time }}</span>
        </div>
        <!--end::Details-->
      </div>
      <!--end::User-->

      <!--begin::Text-->
      <div v-if="text"
        class="p-5 rounded bg-light-info text-dark fw-semobold mw-lg-400px text-start"
        data-kt-element="message-text"
      >
        <!-- {{ text }} -->
        <!-- Displaying dynamic HTML content using v-html directive -->
        <div v-html="text.replace(/\n/g, '<br/>')"></div>
      </div>
      <!-- <div v-if="fileExtension === 'application/pdf'">
        <a :href="fileUrl" target="_blank" style="display: flex; justify-content: center;">
              <img class="card-img-top mt-5" :src="getUrl('pdf')" alt="Card image cap" style="height: 120px; width: 120px;" />
            </a>
            <div class="card-body" style="text-align: center;">
              <a :href="fileUrl" target="_blank" class="card-text">{{fileName}}</a>
            </div>
      </div>
      <div v-else-if="fileExtension === 'application/doc'">
        <a :href="fileUrl" target="_blank" style="display: flex; justify-content: center;">
              <img class="card-img-top mt-5" :src="getUrl('docx')" alt="Card image cap" style="height: 120px; width: 120px;" />
            </a>
            <div class="card-body" style="text-align: center;">
              <a :href="fileUrl" target="_blank" class="card-text">{{fileName}}</a>
            </div>
      </div> -->
          <div>
            <a v-if="fileUrl" :href="fileUrl" target="_blank">
            <img class="file p-2"  v-if="fileUrl"  :src="fileUrl" alt="">
            </a>
            <div class="long-text" style="text-align: center;">
              <a :href="fileUrl" target="_blank" class=""><abbr style="text-decoration: none; cursor: default;" :title="fileName">{{fileName}}</abbr></a>
            </div>
          </div>
      <!--end::Text-->
    </div>
  </div>
  <!--end::Wrapper-->
</template>

<script  lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "message-out",
  props: {
    name: String,
    image: String,
    time: String,
    text: String,
    fileUrl: String,
    fileExtension: String,
    fileName: String
  },
  methods: {
    getUrl(extension) {
      if (extension === 'pdf') {
        return import.meta.env.BASE_URL + 'images/' + `${extension}-icon.png`;
      } else {
        return import.meta.env.BASE_URL + 'images/docx.png';
      }
    }
  },
  setup() {
    const getImageByExtension =(filePath: string) => {
      const extension = getFileExtension(filePath);
      if(extension === 'png' || extension === 'jpg' || extension === 'jpeg'){
      return filePath;
      } else if (extension === 'pdf') {
          return import.meta.env.BASE_URL + 'images/' + `${extension}-icon.png`;
      } else if(extension === 'doc'){
          return import.meta.env.BASE_URL + 'images/docx.png';
      }else{
          return import.meta.env.BASE_URL + 'images/docx.png';
      }
    }
    const getFileExtension = (filename: string) => {
      return filename.split('.').pop().toLowerCase();
    }
    return {
      getImageByExtension
    }
  }
});

</script>

<style>
.file{
  width: 100px;
  height: 100px;
}
.long-text{
        white-space: nowrap;
        text-overflow:ellipsis;
        overflow: hidden;
        max-width:10rem;
}
</style>