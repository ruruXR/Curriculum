<template>
  <a
  style="display: inline-block;"
  v-on:click="storeOrDelete"
  v-if="isActiveTrue"
  class="btn btn-secondary"
  >
    お気に入りに登録
  </a>
  <a
  style="display: inline-block;"
  v-on:click="storeOrDelete"
  v-else
  class="btn btn-primary"
  >
    お気に入りを外す
  </a>
  
</template>

<script>
import axios from 'axios'
export default {
  props: ["postId", "likedData"],
  data() {
    return {
      isActiveTrue: this.likedData.includes(this.postId) ? false : true
    };
  },
  methods: {
    change() {
      this.isActiveTrue = !this.isActiveTrue;
    },
    storepostId() {
      axios
        .post("/like/" + this.postId, {
        postId: this.postId
        })
        .then(response => {
          console.log("success");
        })
        .catch(err => {
          console.log("error");
        });
    },
    deletepostId() {
      axios
        .post("/unlike/" + this.postId, {
          data: {
            postId: this.postId
          }
        })
        .then(response => {
          console.log("success");
        })
        .catch(err => {
          console.log("error");
        });
    },
    storeOrDelete() {
      const isTrue = this.likedData.includes(this.postId);
      if (isTrue === true) {
        this.deletepostId();
        this.change();
      } else {
        this.storepostId();
        this.change();
      }
    }
  }
};
</script>