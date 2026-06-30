import {describe, it, expect, beforeEach} from 'vitest' //importer le squelette du store
import { setActivePinia,createPinia } from 'pinia'
import { useUserStore } from '@/stores/user'

describe('Auth Store', () => {

    beforeEach(()=> {
        setActivePinia(createPinia())
        localStorage.clear()
    })

    //---------------------//
    //-----Etat initial-----//
    //---------------------//
    it('devrait démarrer avec un etat vide',async () => {
        const auth = useUserStore()


        expect(auth.token).toBeNull()
        // expect(auth.isLoggedin).toBe(false)
        // expect(auth.isAdmin).toBe(false)
    })

    //---------------------//
    //-------Register-----//
    //-------------------//
    it('devrait s\'inscrire avec des crédentials valides', async () =>{
        const auth = useUserStore();

        const success = await auth.register('admin@example.com','admin123','pseudo')
        expect(success).toBe(true)
        expect(auth.token).toBeTruthy()
    })
    //---------------------//
    //-----Login valide-----//
    //---------------------//
    it('devrait se connecter avec des crédentials valides',async () => {
        const auth= useUserStore();

        const success = await auth.login('admin@example.com', 'admin123')
        
        expect(success).toBe(true)
        expect(auth.token).toBeTruthy() // toBeTruthy : la valeur existe et n'est pas vide 
    })



    //-------------------------//
    //-----Login Invalide-----//
    //-----------------------//

    it ('devrait échouer avec des crédentiels invalides', async () => {
        const auth = useUserStore();

        const success= await auth.login('inconnu@test.com','mauvais')
        
        expect(success).toBe(false)
        expect(auth.error).toBe('Identifiants Incorrects')
        expect(auth.token).toBeNull()
    })

    //--------------------------------------------//
    //-----Restauration depuis local storage-----//
    //------------------------------------------//
    it('devrait restaurer la session depuis le localstorage', async () => {
        localStorage.setItem(
            'token',
            'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiZW1haWwiOiJhZG1pbkBleGFtcGxlLmNvbSIsInJvbGVzIjpbIlJPTEVfVVNFUiJdLCJleHAiOjk5OTk5OTk5OTl9.test'
        )
        localStorage.setItem('user', JSON.stringify({ id: 1, email: 'admin@example.com' }))

        const auth = useUserStore()
        expect(auth.token).toBeTruthy()
        expect(auth.user).toBeTruthy()
    })

    //------------------//
    //-------Logout-----//
    //-----------------//

    it('devrait nettoyer l\'état au logout',async () => {
        const auth = useUserStore()
        await auth.login('admin@example.com','admin123')
        expect(auth.isLoggedIn).toBe(true)

        auth.logout()

        //après logout tout dois être remis à null
        expect(auth.token).toBeNull()
        expect(auth.user).toBeNull()
        expect(localStorage.getItem('token')).toBeNull()
    })

    

})
