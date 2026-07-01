import { test, expect } from "@playwright/test";

//--------------------//
//-----Connexion-----//
//------------------//

test.describe("Gestion des utilisateurs", () => {
  test.beforeEach(async ({ page }) => {
    await page.goto("/");
    await page.evaluate(() => {
      localStorage.clear();
    });
  });

  test("connexion réussi redirige vers l'accueil", async ({ page }) => {
    await page.goto("/login");
    await page.fill("input#email", "admin@netflux.fr");
    await page.fill("input#password", "admin123");
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL("/");
  });

  test("mauvais mot de passe affiche erreur", async ({ page }) => {
    await page.goto("/login");
    await page.fill("input#email", "admin@netflux.fr");
    await page.fill("input#password", "admin126");
    await page.click('button[type="submit"]');

    await expect(page.locator(".error-message")).toBeVisible();
  });

  
  //-----------------//
  //-----Logout-----//
  //---------------//
  test("un utilisateur se déconnecte", async ({ page }) => {
    //Se connecte avant
    await page.goto("/login");
    await page.fill("input#email", "admin@netflux.fr");
    await page.fill("input#password", "admin123");
    await page.click('button[type="submit"]');
    await expect(page).toHaveURL("/");

    //Puis se déconnecte
    await page.click('button:has-text("Déconnexion")');
    await expect(page).toHaveURL("/");
  });


  //----------------------//
  //-----Inscription-----//
  //--------------------//
  test("Un utilisateur devrait pouvoir s'inscrire", async ({ page }) => {
    await page.goto("/");

    //naviguer vers la page d'inscription
    await page.click('a:has-text("S\'inscrire")');
    await expect(page).toHaveURL("/register");

    //remplir le formulaire
    await page.fill("input#pseudo", "Usertest");

    //utiliser un email unique à chaque run de test
    const email = `usertest_${Date.now()}@gmail.com`;
    await page.fill("input#email", email);
    await page.fill("input#password", "usertest123");

    //soumettre le formulaire
    await page.click('button[type="submit"]');

    //vérifier le redirection après inscription réussie
    await expect(page).toHaveURL("/");


    //------------------//
    //-----Favoris-----//
    //----------------//
    test("un utilisateur ajoute un film en favoris", async ({ page }) => {
      await page.goto("/movies");
      await page.click('button:has-text("Ajouter aux favoris")');
    });
  });
});
