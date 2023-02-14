### Prerequisites

1. A recent web browser (Chrome, Edge, Firefox, ...)
2. PHP with composer installed
3. [Nodejs LTS](https://nodejs.org/en/) _(> 16.x with npm >8)_ installed
4. Knowledge with [Typescript](https://github.com/microsoft/typescript) _(> 4.x)_ (should not be installed globally)
5. (recommended) [VSCode](https://code.visualstudio.com/ with [Volar](https://marketplace.visualstudio.com/items?itemName=vue.volar)

### To setup the template and start installing project dependencies, run one of the following commands:

```bash
composer install
cp .env.example .env
php artisan key:generate
```

```bash
# using pnpm (recommended)
pnpm install
```

Note that you can also use other package manager (npm or yarn) but we recommend using pnpm:

```bash
# using npm
npm install

# using yarn
yarn install
```

### 🔃 Run a development server

To start the development server, run one of the following commands:

```bash
# using pnpm (recommended)
pnpm dev
```

Using npm or yarn

```bash
# using npm
npm run dev

# using yarn
yarn dev
```

This will run the `dev` script from the `package.json` file.

To build production version, run the following command:

```bash
# using pnpm (recommended)
pnpm build
```

Using npm or yarn

```bash
# using npm
npm run build

# using yarn
yarn build
```
