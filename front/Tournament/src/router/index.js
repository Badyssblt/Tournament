import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/LoginView.vue";
import DashboardView from "@/views/DashboardView.vue";
import TournamentView from "@/views/TournamentView.vue";
import TournamentPage from "@/views/TournamentPage.vue";

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
  ],
});

export default router;