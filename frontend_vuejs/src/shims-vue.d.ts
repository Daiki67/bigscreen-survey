// Déclare tous les fichiers se terminant par .vue comme des modules Vue valides
// Cela permet à TypeScript de comprendre les imports de composants .vue

declare module '*.vue' {
  import { DefineComponent } from 'vue';
  // Chaque fichier .vue exporte un composant Vue typé génériquement
  const component: DefineComponent<{}, {}, any>;
  export default component;
}

// Déclare tous les fichiers se terminant par .js comme des modules valides
// Cela évite les erreurs lors de l'import de fichiers JavaScript dans un projet TypeScript

declare module '*.js';
