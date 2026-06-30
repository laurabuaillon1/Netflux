// @ts-check
import { test, expect } from "@playwright/test";

test.describe("Gestion des films en E2E", () => {
  test.beforeEach(async ({ page }) => {
    await page.goto("/");
    await page.evaluate(() => {
      localStorage.clear();
    });
  });

  //----------------//
  //-----FILMS-----//
  //---------------//
  test("devrait afficher la liste des films", async ({ page }) => {
    await page.goto("/movies");

    // Expect a title "to contain" a substring.
    await expect(page.locator(".movie-card").first()).toBeVisible();
  });

  // test("get started link", async ({ page }) => {
  //   await page.goto("https://playwright.dev/");

  //   // Click the get started link.
  //   await page.getByRole("link", { name: "Get started" }).click();

  //   // Expects page to have a heading with the name of Installation.
  //   await expect(
  //     page.getByRole("heading", { name: "Installation" }),
  //   ).toBeVisible();
  // });

  test("devrait filtrer par genre la liste des films", async ({ page }) => {
    await page.goto("/movies");
    await page.selectOption("select#genre", "Comédie");

    await expect(page.locator(".movie-card").first()).toBeVisible();
  });

  test("devrait afficher les détails d'un film", async ({ page }) => {
    await page.goto("/movies");
    await page.hover('.movie-card');
    await page.click('button:has-text("Informations")');
    
  });



  //----------------//
  //-----Connexion-----//
  //---------------//

  test("connexion réussi redirige vers l'accueil", async ({ page }) => {
    await page.goto("/login");
    await page.fill('input#email','admin@netflux.fr');
    await page.fill('input#password','admin123');
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL('/');
    
  });

  test("mauvais mot de passe affiche erreur", async ({ page }) => {
    await page.goto("/login");
    await page.fill('input#email','admin@netflux.fr');
    await page.fill('input#password','admin126');
    await page.click('button[type="submit"]');

    await expect(page.locator('.error-message')).toBeVisible();
    
  });

  test("un utilisateur ajoute un film en favoris",async ({page}) =>{
    await page.goto("/movies");
    await page.click('button:has-text("Ajouter aux favoris")');
  })

});
