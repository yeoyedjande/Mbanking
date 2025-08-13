<?php 
  $verif_caisse =  DB::table('mouvements')->Where('guichetier', Auth::user()->id)
        ->Where('date_mvmt', date('d/m/Y'))
        ->first();
?>

<div id="sidebar" class="active">

      <div class="sidebar-wrapper active">

        <div class="sidebar-header position-relative">

          <div class="d-flex justify-content-between align-items-center">

            <div class="logo">

              <a href="{{ route('dashboard') }}"

                >

                <!--<img src="/assets/images/logo/logo.svg" alt="Logo" srcset=""

              />-->

                <h4>Hbanking</h4>

              </a>

            </div>

            <div class="theme-toggle d-flex gap-2 align-items-center mt-2">

              <svg

                xmlns="http://www.w3.org/2000/svg"

                xmlns:xlink="http://www.w3.org/1999/xlink"

                aria-hidden="true"

                role="img"

                class="iconify iconify--system-uicons"

                width="20"

                height="20"

                preserveAspectRatio="xMidYMid meet"

                viewBox="0 0 21 21"

              >

                <g

                  fill="none"

                  fill-rule="evenodd"

                  stroke="currentColor"

                  stroke-linecap="round"

                  stroke-linejoin="round"

                >

                  <path

                    d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"

                    opacity=".3"

                  ></path>

                  <g transform="translate(-210 -1)">

                    <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>

                    <circle cx="220.5" cy="11.5" r="4"></circle>

                    <path

                      d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"

                    ></path>

                  </g>

                </g>

              </svg>

              <div class="form-check form-switch fs-6">

                <input

                  class="form-check-input me-0"

                  type="checkbox"

                  id="toggle-dark"

                  style="cursor: pointer"

                />

                <label class="form-check-label"></label>

              </div>

              <svg

                xmlns="http://www.w3.org/2000/svg"

                xmlns:xlink="http://www.w3.org/1999/xlink"

                aria-hidden="true"

                role="img"

                class="iconify iconify--mdi"

                width="20"

                height="20"

                preserveAspectRatio="xMidYMid meet"

                viewBox="0 0 24 24"

              >

                <path

                  fill="currentColor"

                  d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"

                ></path>

              </svg>

            </div>

            <div class="sidebar-toggler x">

              <a href="#" class="sidebar-hide d-xl-none d-block"

                ><i class="bi bi-x bi-middle"></i

              ></a>

            </div>

          </div>

        </div>



        <div class="sidebar-menu">

          <ul class="menu">

            <li class="sidebar-title">Menu</li>



            <li class="sidebar-item active">

              <a href="{{ route('dashboard') }}" class="sidebar-link">

                <i class="bi bi-house-door-fill"></i>

                <span>Tableau de bord</span>

              </a>

            </li>



            @can('is-caissier')



            <?php if ( isset($verif_caisse) ){ ?>



              <?php if ( $verif_caisse->verify == 'yes' ){ ?>

              <li class="sidebar-item has-sub">

                <a href="#" class="sidebar-link">

                  <i class="bi bi-stack"></i>

                  <span>Transactions</span>

                </a>

                <ul class="submenu">

                  <li class="submenu-item">

                    <a href="{{ route('versements') }}">Versements</a>

                  </li>

                  <li class="submenu-item">

                    <a href="{{ route('retraits') }}">Retraits</a>

                  </li>

                </ul>

              </li>

              <li class="sidebar-item has-sub">

                <a href="#" class="sidebar-link">

                  <i class="bi bi-stack"></i>

                  <span>Opérations Spéciales</span>

                </a>

                <ul class="submenu">

                  <li class="submenu-item">

                    <a href="{{ route('releve-start') }}">Relevés Bancaire</a>

                  </li>

                  <li class="submenu-item">

                    <a href="{{ route('chequiers') }}">Commande de chéquiers</a>

                  </li>

                </ul>

              </li>

            <?php } } ?>

            @endcan



            @can('is-receptioniste')

            <li class="sidebar-item has-sub">

              <a href="#" class="sidebar-link">

                <i class="bi bi-stack"></i>

                <span>Clients</span>

              </a>

              <ul class="submenu">

                <li class="submenu-item">

                  <a href="{{ route('account-index') }}">Ouverture</a>

                </li>

                <li class="submenu-item">

                  <a href="{{ route('accounts') }}">Liste des clients</a>

                </li>

              </ul>

            </li>



            <li class="sidebar-item">

              <a href="{{ route('demande-credit') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Demande de credit</span>

              </a>

            </li>



            <li class="sidebar-item">

              <a href="{{ route('correspondances') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Correspondances</span>

              </a>
 
            </li>

            <li class="sidebar-item">

              <a href="#" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Visiteurs</span>

              </a>

            </li>

            @endcan



            @can('is-caissier')

            <?php if ( isset($verif_caisse) ){ ?>

              <?php if ( $verif_caisse->verify == 'yes' ){ ?>

                <li class="sidebar-item">

                  <a href="{{ route('accounts-consultation') }}" class="sidebar-link">

                    <i class="bi bi-grid-fill"></i>

                    <span>Consulter un compte</span>

                  </a>

                </li>
                <li class="sidebar-item">

                  <a href="{{ route('caisse-cloture') }}" class="sidebar-link">

                    <i class="bi bi-grid-fill"></i>

                    <span>Fermeture de caisse</span>

                  </a>

                </li>
              <?php }} ?>

              

                <li class="sidebar-item">

                  <a href="{{ route('caisse-cloture-report-close') }}" class="sidebar-link">

                    <i class="bi bi-grid-fill"></i>

                    <span>Rapport de clôture</span>

                  </a>

                </li>

                <li class="sidebar-item has-sub">

                  <a href="#" class="sidebar-link">

                    <i class="bi bi-search"></i>

                    <span>Historiques</span>

                  </a>

                  <ul class="submenu">

                    <li class="submenu-item">

                      <a href="{{ route('versement-historique') }}">Versements</a>

                    </li>

                    <li class="submenu-item">

                      <a href="{{ route('retrait-historique') }}">Retraits</a>

                    </li>
                  </ul>

                </li>

            @endcan

            @can('is-service-operation')
              <li class="sidebar-item">

                <a href="{{ route('caisse-create') }}" class="sidebar-link">

                  <i class="bi bi-grid-fill"></i>

                  <span>Créer une caisse</span>

                </a>

              </li>

              <li class="sidebar-item">

                <a href="{{ route('caisse-reajustement') }}" class="sidebar-link">

                  <i class="bi bi-grid-fill"></i>

                  <span>Reajustement de caisse</span>

                </a>

              </li>

              <li class="sidebar-item">
                <a href="{{ route('transaction-attente') }}" class="sidebar-link">
                  <i class="bi bi-wallet2"></i>
                  <span>Valider une transaction</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a href="{{ route('accounts-consultation') }}" class="sidebar-link">
                  <i class="bi bi-person-workspace"></i>
                  <span>Consulter un compte</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                  <i class="bi bi-bank"></i>
                  <span>Rembourser un prêt</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                  <i class="bi bi-printer"></i>
                  <span>Imprimer un relevé</span>
                </a>
              </li>

            @endcan

            @can('is-direction')
              <li class="sidebar-item">
                <a href="{{ route('caisse-create') }}" class="sidebar-link">
                  <i class="bi bi-grid-fill"></i>
                  <span>Créer une caisse</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a href="{{ route('demande_attente') }}" class="sidebar-link">
                  <i class="bi bi-grid-fill"></i>
                  <span>Demandes en attentes</span>
                </a>
              </li>


              <li class="sidebar-item">

                <a href="{{ route('caisse-reajustement') }}" class="sidebar-link">

                  <i class="bi bi-grid-fill"></i>

                  <span>Reajustement de caisse</span>

                </a>

              </li>

              <li class="sidebar-item">
                <a href="{{ route('transaction-attente') }}" class="sidebar-link">
                  <i class="bi bi-wallet2"></i>
                  <span>Valider une transaction</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a href="{{ route('accounts-consultation') }}" class="sidebar-link">
                  <i class="bi bi-person-workspace"></i>
                  <span>Consulter un compte</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                  <i class="bi bi-bank"></i>
                  <span>Rembourser un prêt</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                  <i class="bi bi-printer"></i>
                  <span>Imprimer un relevé</span>
                </a>
              </li>

            @endcan

            @can('is-comptable')
              <li class="sidebar-item">
                <a href="{{ route('virements') }}" class="sidebar-link">
                  <i class="bi bi-grid-fill"></i>
                  <span>Virements</span>
                </a>
              </li>

              <li class="sidebar-item">
                <a href="{{ route('coffre-fort') }}" class="sidebar-link">
                  <i class="bi bi-grid-fill"></i>
                  <span>Coffres forts</span>
                </a>
              </li>

              <li class="sidebar-item has-sub">

                  <a href="#" class="sidebar-link">

                    <i class="bi bi-search"></i>

                    <span>Rapports</span>

                  </a>

                  <ul class="submenu">

                    <li class="submenu-item">

                      <a href="{{ route('rapport-versement') }}">Versements</a>

                    </li>

                    <li class="submenu-item">

                      <a href="{{ route('rapport-retrait') }}">Retraits</a>

                    </li>
                    
                    <li class="submenu-item">
                      <a href="{{ route('rapport-virement') }}">Virements</a>
                    </li>


                    <li class="submenu-item">

                      <a href="{{ route('rapport-chequiers') }}">Chequiers</a>

                    </li>
                  </ul>

                </li>

                <li class="sidebar-item">
                  <a href="{{ route('gestion-comptable') }}" class="sidebar-link">
                    <i class="bi bi-grid-fill"></i>
                    <span>Plan comptable</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a href="{{ route('balance') }}" class="sidebar-link">
                    <i class="bi bi-grid-fill"></i>
                    <span>Balance Comptable</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a href="{{ route('grand-livre') }}" class="sidebar-link">
                    <i class="bi bi-grid-fill"></i>
                    <span>Grand Livre</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="{{ route('journal-start') }}" class="sidebar-link">
                    <i class="bi bi-grid-fill"></i>
                    <span>Journal Comptable</span>
                  </a>
                </li>

                <li class="sidebar-item">
                  <a href="{{ route('ecritures-mannuelles') }}" class="sidebar-link">
                    <i class="bi bi-grid-fill"></i>
                    <span>Ecritures manuelles Comptable</span>
                  </a>
                </li>


                <li class="sidebar-item">
                  <a href="{{ route('depenses-revenus') }}" class="sidebar-link">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dépenses / Revenus</span>
                  </a>
                </li>
            @endcan

            @can('is-caissier-principal')

            <li class="sidebar-item">

              <a href="{{ route('caisse') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Opérations de caisse</span>

              </a>

            </li>

            

            <li class="sidebar-item">

              <a href="{{ route('caisse-historique') }}" class="sidebar-link">

                <i class="bi bi-search"></i>

                <span>Historiques</span>

              </a>

            </li>

            @endcan



            @can('is-analyste-credit')

            <li class="sidebar-item">

              <a href="{{ route('liste-credits') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Les crédits octroyés</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('liste-demandes-assign') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Demandes de crédits</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('simulation-liste') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Liste des simulations</span>

              </a>

            </li>


            <li class="sidebar-item">

              <a href="{{ route('dossier-traite') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Mes dossiers traités</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('accounts-consultation') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Consulter un compte</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('editions-bancaire') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Edition de carte</span>

              </a>

            </li>

            @endcan



            @can('is-chef-service-credit')

            <li class="sidebar-item">

              <a href="{{ route('demande_attente') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Demandes en attente</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('liste-demandes') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Voir les demandes</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('accounts-consultation') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Consulter un compte</span>

              </a>

            </li>

            @endcan

            @can('is-admin')
            <li class="sidebar-item">

              <a href="{{ route('seuil') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Définition des seuils</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('agences') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Agences</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('frais') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Frais</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('billets.index') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Billets</span>

              </a>

            </li>

           <li class="sidebar-item">

              <a href="{{ route('taux.index') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Taux</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('etat-credit-index') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Etat de crédit</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('banquexternes') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Banques externes</span>

              </a>

            </li>

            <li class="sidebar-item">

              <a href="{{ route('plafonds-index') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Gestion des plafonds</span>

              </a>

            </li>


            <li class="sidebar-item">

              <a href="{{ route('type_biens.demande.index') }}" class="sidebar-link">

                <i class="bi bi-grid-fill"></i>

                <span>Type Biens/Objet Demande</span>

              </a>

            </li>

            @endcan

            @can('is-admin')

              <li class="sidebar-item has-sub">

                <a href="#" class="sidebar-link">

                  <i class="bi bi-gear-fill"></i>

                  <span>Réglage système</span>

                </a>

                <ul class="submenu">


                  <li class="submenu-item">

                      <a href="{{ route('change.autre.mot-passe') }}"><i class="bi bi-key"></i> Modifier Autre Mot de Passe</a>

                  </li>

                  <!-- <li class="submenu-item">
                      <a href="#"><i class="bi bi-gear"></i> Gestion des tables de paramétrage</a>
                  </li>

                  <li class="submenu-item">
                      <a href="#"><i class="bi bi-calendar"></i> Visualisation jours ouvrables</a>
                  </li>

                  <li class="submenu-item">
                      <a href="#"><i class="bi bi-currency-exchange"></i> Gestion des devises</a>
                  </li> -->


                  <li class="submenu-item">

                      <a href="{{ route('types_credits.index') }}"><i class="bi bi-credit-card"></i> Type crédit</a>

                  </li>


                </ul>

              </li>
            
            @endcan

            <li class="sidebar-item has-sub">

              <a href="#" class="sidebar-link">

                <i class="bi bi-gear-fill"></i>

                <span>Paramètres</span>

              </a>

              <ul class="submenu">



                <li class="submenu-item">

                  <a href="{{ route('profil-user') }}"><i class="bi bi-person-circle"></i> Mon compte</a>

                </li>



                @can('is-admin')

                <li class="submenu-item">

                  <a href="{{ route('users') }}">Utilisateurs</a>

                </li>

                <li class="submenu-item">

                  <a href="{{ route('roles') }}">Rôles</a>

                </li>

                

                <li class="submenu-item">

                  <a href="{{ route('permissions') }}">Autorisations</a>

                </li>

                <li class="submenu-item">

                  <a href="#"><i class="bi bi-lock"></i> Arrêt du système</a>

                </li>

                @endcan



                



              </ul>

            </li>

           

            <li class="sidebar-item">

              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="width:100%;" class="btn btn-danger">

                <i class="bi bi-power"></i>

                <span>Se deconnecter</span>

              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">

                  @csrf

              </form>

            </li>

          </ul>

        </div>

      </div>

    </div>

    <div id="main">