<script setup lang="ts">
    import SocialLinks from './SocialLinks.vue'
    </script>
    
    <template>
      <footer class="bg-[#106A59] text-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-8">
          <div>
            <h3 class="font-bold text-lg">Mr Lana</h3>
            <p class="text-sm mt-2 opacity-80">
              Créditos rápidos, claros y sin rodeos.
            </p>
          </div>
    
          <div>
            <p class="font-semibold mb-2">Legales</p>
            <ul class="space-y-2 text-sm opacity-90">
              <li><a href="/aviso-de-privacidad">Aviso de privacidad</a></li>
              <li><a href="/terminos-y-condiciones">Términos y condiciones</a></li>
            </ul>
          </div>
    
          <SocialLinks />
        </div>
      </footer>
    </template>
    