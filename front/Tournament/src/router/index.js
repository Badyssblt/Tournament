import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/LoginView.vue";
import DashboardView from "@/views/DashboardView.vue";
import TournamentView from "@/views/TournamentView.vue";
import TournamentPage from "@/views/TournamentPage.vue";
import RegisterView from "@/views/RegisterView.vue";
import CreateTournamentView from "@/views/CreateTournamentView.vue";
import SearchResultView from "@/views/SearchResultView.vue";
import FAQView from "@/views/FAQView.vue";
import VerifyAccount from "@/views/VerifyAccount.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
    },
    {
      path: "/dashboard",
      name: "dashboard",
      component: DashboardView,
    },
    {
      path: "/tournament/:id",
      name: "singleTournament",
      component: TournamentView,
    },
    {
      path: "/tournament/:id/view",
      name: "tournamentView",
      component: TournamentPage,
    },
    {
      path: "/register",
      name: "Register",
      component: RegisterView,
    },
    {
      path: "/tournament/create",
      name: "CreateTournament",
      component: CreateTournamentView,
    },
    {
      path: "/search",
      name: "Search",
      component: SearchResultView,
    },
    {
      path: "/faq/:answer",
      name: "FAQ",
      component: FAQView,
    },
    {
      path: "/verify/:id",
      name: "VerifyAccount",
      component: VerifyAccount,
    },
  ],
});

export default router;
