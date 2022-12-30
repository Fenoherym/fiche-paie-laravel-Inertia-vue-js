<template>
    <div class="body">
        <div class="_container">
            <aside>
                <div class="top">
                    <div class="_logo">
                        <img :src="logoUrl" alt="logo">
                        <!-- <h2 class="logo__text text-center">MyL<span class="_danger">OGO</span></h2> -->
                    </div>
                    <div class="_close" id="close-btn">
                        <i class="fa-solid fa-xmark" @click="closeMenu()"></i>
                    </div>
                </div>
                <div class="_sidebar">
                    <Link href="/" :class="{ active: route ==='/'}" v-if="isAdmin">
                    <span><i class="fa-solid fa-dashboard"></i></span>
                    <h3>Tableau de bord</h3>
                    </Link>
                    <Link href="/personnels"
                        :class="{ active: route.slice(0,10) =='/personnel' &&  route !='/personnel/absences'}"
                        v-if="isAdmin">
                    <span class="material-icons-sharp"><i class="fa-solid fa-user"></i></span>
                    <h3>Employés</h3>
                    </Link>
                    <Link href="/paies" :class="{ active: route.slice(0,5) =='/paie' }">
                        <span ><i class="fa-solid fa-newspaper"></i></span>
                        <h3 v-if="isAdmin">Paie</h3>
                        <h3 v-else>Mes fiches</h3>
                    </Link>
                    <Link href="/personnel/absences" :class="{ active: route ==='/personnel/absences'}">
                        <span><i class="fa-solid fa-xmark"></i></span>
                        <h3 v-if="isAdmin">Absences</h3>
                        <h3 v-else>Mes absences</h3>
                    </Link>
                    <Link href="/rubriques" :class="{ active: route.slice(0,9) =='/rubrique'}" v-if="isAdmin">
                        <span><i class="fa-solid fa-credit-card"></i></span>
                        <h3>Rubriques</h3>
                    </Link>
                    <Link href="/conges" :class="{ active: route.slice(0,6) =='/conge'}">
                        <span><i class="fa-solid fa-calendar-days"></i></span>
                        <h3 v-if="isAdmin">Congés</h3>
                        <h3 v-else>Mes congés</h3>
                    </Link>
                    <Link href="#" @click="logout()">
                        <span ><i class="fa-solid fa-right-from-bracket"></i></span>
                        <h3>Déconnexion</h3>
                        <form action="/logout" method="post" id="logout-form">
                            <input type="text" name="_token" :value="csrf" hidden>
                        </form>
                    </Link>
                </div>
            </aside>
            <main>
                <Navbar :message_count="count"/>
                <slot />
            </main>
        </div>

    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import { Link, usePage } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Navbar,
        Link,

    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            isAdmin: false,
            count: 0,
            logoUrl: ''
        }
    },
    props: ['route'],
    methods: {
        closeMenu() {
            let aside = document.querySelector('aside');
            aside.style.display = "none"
        },
        logout() {
            document.querySelector('#logout-form').submit();
        }
    },
    created() {
        this.user = usePage().props.value.auth.user
        this.isAdmin = this.user.role.name.toLowerCase() === 'admin'.toLowerCase()
        this.count = usePage().props.value.count
        this.logoUrl = usePage().props.value.logoUrl
    },updated(){
        this.count = usePage().props.value.count
        this.logoUrl = usePage().props.value.logoUrl
    }
}
</script>

<style scoped>
* {
    margin: 0;
    padding: 0;
    outline: 0;
    box-sizing: border-box;
    appearance: none;
    text-decoration: none;
    list-style: none;
}

.body {
    font-size: 14px;
    height: 100vh;
    font-family: 'poppins', sans-serif;
    font-size: 0.88rem;
    background: var(--color-background);
    overflow-x: hidden;
}

._container {
    display: grid;
    width: 96%;
    margin: 0 auto;
    gap: 1.8rem;
    grid-template-columns: 14rem auto;
}

a {
    color: var(--color-dark);
}

h1 {
    font-weight: 800;
    font-size: 1.8rem;
}

h2 {
    font-size: 1.4rem;
}

h3 {
    font-size: 0.87rem;
}

h4 {
    font-size: 0.8rem;
}

h4 {
    font-size: 0.77rem;
}

._logo img {
    width: 150px;
    height: auto;
}

._logo .logo__text {
    color: var(--color-dark);
}

aside {
    height: 100vh;
}

aside .top {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

aside ._close {
    display: none;
}

/*** sidebar */
aside ._sidebar {
    display: flex;
    flex-direction: column;
    height: 86vh;
    position: relative;
}

aside h3 {
    font-weight: 500;
}

aside ._sidebar a {
    display: flex;
    color: var(--color-info-dark);
    margin-left: 2rem;
    gap: 1rem;
    align-items: center;
    position: relative;
    height: 3.7rem;
    transition: all 300ms ease;
}

aside ._sidebar a span {
    font-size: 1.4rem;
    transition: all 300ms ease;
}

aside ._sidebar a:last-child {
    position: absolute;
    bottom: 2rem;
    width: 100%;
}

aside ._sidebar a.active {
    background: var(--color-light);
    margin-left: 0;
}

aside ._sidebar a.active::before {
    content: '';
    width: 6px;
    height: 100%;
    background: #2697d8;
}

aside ._sidebar a.active span {
    color: #2697d8;
    margin-left: calc(1rem - 3px);
}

aside ._sidebar a:hover {
    color: #2697d8;
}

aside ._sidebar a:hover span {
    margin-left: 1rem;
}



/** Main */
/* main{
        margin-top: 1.4rem;
   } */

/** Media query */
@media screen and (max-width: 960px) {
    ._container {
        grid-template-columns: 6rem auto;
    }

    aside ._logo h2 {
        display: none;
    }

    aside ._sidebar h3 {
        display: none;
    }

    aside .sidebar a {
        width: 4.5rem;
    }

    aside ._sidebar a:last-child {
        position: relative;
        margin-top: 1.8rem;
    }

}

@media screen and (max-width: 768px) {
    ._container {
        grid-template-columns: 100%;
    }

    aside {
        position: fixed;
        left: -100%;
        background: var(--color-white);
        width: 18rem;
        z-index: 3;
        box-shadow: 1rem 3rem 4rem var(--color-light);
        height: 100vh;
        padding-right: 1.8rem;
        display: none;
        animation: showMenu 400ms ease forwards;
    }

    @keyframes showMenu {
        to {
            left: 0;
        }
    }

    aside ._logo {
        margin-left: 1rem;
    }

    aside ._logo h2 {
        display: inline;
    }

    aside ._sidebar h3 {
        display: inline;
    }

    aside ._sidebar a {
        width: 100%;
        height: 3.4rem;
    }

    aside .sidebar a:last-child {
        position: absolute;
        bottom: 5rem;
    }

    aside ._close {
        display: inline-block;
        cursor: pointer;
    }

    aside ._close i {
        color: var(--color-dark);
    }

    main {
        padding: 0 1rem;
        width: 100%;
    }

}
</style>
