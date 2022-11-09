<template>
  <div class="side-bar" :class="{'desactivate-menu': !menuActive}">
    <ion-icon   name="menu"   class="menu-icon" @click="toggleMenu"></ion-icon>
    <div class="menu-title">
        <transition name="appear">
            <h1 v-if="menuActive">{{ activeTitle }}</h1>
        </transition>
    </div>

    <ul id="menu-list"  >
      <li
        v-for="(list, index) in menu"
        :key="index"
        :class="{ active: list.active }"
        @click="changelist(index)"
      >
        <div>
            <ion-icon
              :name="list.icon"
              :class="{ activeIcon: list.active }"
            ></ion-icon>
            <transition name="appear">
                <span   v-if="menuActive">{{ list.title }}</span>
            </transition>
        </div>
      </li>


      <!-- <li><ion-icon name="home"></ion-icon><span>Home</span></li>
            <li><ion-icon name="notifications"></ion-icon><span>Notifications</span></li>
            <hr>
            <li><ion-icon name="finger-print"></ion-icon><span>My profile</span></li>
            <li><ion-icon name="clipboard"></ion-icon><span>My absences</span></li>
            <li><ion-icon name="albums"></ion-icon><span>My modules</span></li> -->
    </ul>
  </div>
</template>

<script>
import bus from '../../EventBus'

export default {
  name: "StSideBar",
  components: {},
  data() {
    return {
      list: "",
      menu: [
        { title: "Home", icon: "home", active: false },
        { title: "Notifications", icon: "notifications", active: false },
        { title: "My profile", icon: "person", active: false },
        { title: "My absences", icon: "clipboard", active: false },
        { title: "My modules", icon: "albums", active: false },
      ],
      menuActive: false,
      activeTitle: '',
    };
  },

  methods: {
    toggleMenu() {
        this.menuActive = !this.menuActive
        bus.$emit('changeMenu', this.menuActive);
    },

    changelist(i) {
      this.menu.forEach((element) => {
        element.active = false;
      });
      this.menu[i].active = true;
      this.activeTitle = this.menu[i].title
    },

  },

  mounted() {
    const hr = document.createElement("hr");
    hr.style.margin = '20px 0'
    this.list = document.querySelector("#menu-list");
    this.list.children[1].after(hr);
    this.changelist(0);
  },
};
</script>


<style scoped>
.appear-enter{
    opacity: 0;
}

.appear-enter-active{
    transition: opacity 1s;
}

.side-bar {
  width: 260px;
  height: 100vh;
  padding: 30px 0 30px 20px;
  background: linear-gradient(180deg, #2c4eb4, #305748, #305748,#305748,  #305748);
  /* background-color: #3E7E3F; */
  position: fixed;
  top: 0;
  left: 0;
  color: #fff;
  transition: all ease .4s;
}

.desactivate-menu{
    width: 60px;
    transition: all ease .4s;
}


.menu-title{
    padding-left: 30px;
    height: 120px;
  font-size: 15px;
  text-align: center;
  font-weight: 700;
}


.borders-after {
  border-radius: 0 15px 0 0 !important;
}

.borders-before {
  border-radius: 0 0 15px 0 !important;
}

li {
  height: 100px;
  font-size: 18px;
  font-weight: 600;
  width: 100%;
  display: flex;
  align-content: space-between;
  cursor: pointer;
  flex-direction: row;
  flex-wrap: wrap;
}

li div {
    display: flex;
    flex-direction: row;
    align-items: center;
    height: 50px;
}

li::before{
    content: '';
    width: 100%;
    height: 15px;
    /* background: linear-gradient(-90deg, #2c4eb4, #2c4eb4,  #3E7E3F); */
  background-color: #305748;

    border-bottom-right-radius: 15px;
}

li::after{
    content: '';
    width: 100%;
    height: 15px;
    /* background: linear-gradient(-90deg, #2c4eb4,#2c4eb4, #3E7E3F); */
  background-color: #305748;

    border-top-right-radius: 15px;


}

li span {
  margin-left: 30px;
  opacity: 1;

}

.active {
  background-color: #fff;
  color: #2c4eb4;
  border-radius: 50px 0 0 50px;
  /* background: linear-gradient(-90deg, #fff, #fff, #fff,#fff, #3E7E3F); */

}

.activeIcon {
  color: #2c4eb4 !important;
}

ion-icon {
  margin-left: 10px;
  font-size: 35px;
  color: #fff;
  visibility: visible;
  min-width: 40px;
}
</style>
