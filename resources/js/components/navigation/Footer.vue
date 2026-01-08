<script setup lang="ts">
    import { nextTick, onMounted } from 'vue'
    
    const uiKitUpdate = async () => {
      await nextTick()
      ;(window as any).UIkit?.update?.()
    }
    onMounted(uiKitUpdate)
    </script>
    
    <template>
      <!-- Desktop Footer -->
      <footer class="uk-padding-remove-top footer-mrlana uk-visible@l">
        <div class="uk-flex">
          <div class="uk-width-1-3">
            <img
              src="/img/footer-degree.png"
              alt="Footer Degree"
              class="uk-position-overlay"
              loading="lazy"
            />
          </div>
    
          <div class="uk-flex uk-width-1-1 uk-margin-auto-vertical">
            <div class="uk-width-1-2">
              <div class="uk-flex uk-flex-center">
                <div class="uk-width-1-2">
                  <div class="uk-flex uk-flex-column">
                    <span style="margin-bottom: 1rem"><b>Contáctanos</b></span>
    
                    <span>Atención al cliente</span>
                    <div class="uk-flex uk-margin-small-top">
                      <span
                        ><img
                          src="/img/icons/icon-phone.png"
                          alt="Teléfono"
                          style="width: 20px"
                          loading="lazy"
                      /></span>
                      <a href="tel:7774225973" class="uk-margin-left">(777) 422-5973</a>
                    </div>
    
                    <span style="margin-top: 2rem">Servicio al cliente</span>
                    <span>LUN-SAB: 10:00am a 8:00pm</span>
    
                    <span style="margin-top: 2rem" class="uk-margin-medium-top"
                      >atencionclientes@mr-lana.com</span
                    >
                  </div>
                </div>
              </div>
            </div>
    
            <div class="uk-width-1-2">
              <div class="uk-flex">
                <div class="uk-width-1-2 uk-text-nowrap">
                  <div class="uk-flex uk-flex-column">
                    <span>Síguenos en:</span>
    
                    <div class="uk-flex uk-margin-top">
                      <span class="uk-margin-right"
                        ><img src="/img/icons/logo-fb.png" style="width: 20px" loading="lazy"
                      /></span>
                      <a
                        href="https://www.facebook.com/people/Mr-Lana/61552688275964/"
                        target="_blank"
                        rel="noreferrer"
                        >Facebook</a
                      >
                    </div>
    
                    <div class="uk-flex uk-margin-top">
                      <span class="uk-margin-right"
                        ><img src="/img/icons/logo-ig.png" style="width: 20px" loading="lazy"
                      /></span>
                      <a href="https://www.instagram.com/mrlana.mx/" target="_blank" rel="noreferrer"
                        >Instagram</a
                      >
                    </div>
    
                    <div class="uk-margin-medium-top">
                      <span
                        ><a href="/terminos-y-condiciones">Términos y condiciones</a> /
                        <a href="/aviso-de-privacidad">Aviso de privacidad</a></span
                      >
                    </div>
                    <div class="uk-margin-small-top">
                      <span><a href="/faqs">Preguntas Frecuentes (FAQ's)</a></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /right -->
          </div>
        </div>
      </footer>
    
      <!-- Mobile Footer -->
      <footer class="uk-padding-remove-top footer-mrlana uk-hidden@l">
        <div class="uk-width-1-1 mobile-degree-mrlana uk-margin-medium-bottom"></div>
    
        <div class="uk-flex uk-flex-center">
          <div class="uk-width-1-2">
            <div class="uk-flex uk-flex-column">
              <span><b>Contáctenos</b></span>
    
              <span class="uk-margin-top">Atención al cliente</span>
              <div class="uk-flex">
                <span
                  ><img src="/img/icons/icon-phone.png" style="width: 70%" loading="lazy"
                /></span>
                <a href="tel:7774225973">(777) 422-5973</a>
              </div>
    
              <span class="uk-margin-top">atencionclientes@mr-lana.com</span>
    
              <span class="uk-margin-top">Servicio al cliente</span>
              <span>LUN-SAB: 10:00am a 8:00pm</span>
            </div>
          </div>
    
          <div class="uk-width-1-3">
            <div class="uk-flex uk-flex-column">
              <span>Síguenos en:</span>
    
              <div class="uk-flex">
                <span class="uk-margin-right"
                  ><img src="/img/icons/logo-fb.png" style="width: 20px" loading="lazy"
                /></span>
                <a
                  href="https://www.facebook.com/people/Mr-Lana/61552688275964/"
                  target="_blank"
                  rel="noreferrer"
                  >Facebook</a
                >
              </div>
    
              <div class="uk-flex uk-margin-top">
                <span class="uk-margin-right"
                  ><img src="/img/icons/logo-ig.png" style="width: 20px" loading="lazy"
                /></span>
                <a href="https://www.instagram.com/mrlanamx/" target="_blank" rel="noreferrer"
                  >Instagram</a
                >
              </div>
            </div>
          </div>
        </div>
    
        <div class="uk-width-1-1 uk-text-center uk-margin-medium-top">
          <span
            ><a href="/terminos-y-condiciones">Términos y condiciones</a> /
            <a href="/aviso-de-privacidad">Aviso de privacidad</a></span
          >
        </div>
      </footer>
    </template>
    