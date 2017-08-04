# Банк бус санхүүгийн систем

fork хийсэн repository-г clone хийж авсаны дараа git-дээ upstream remote нэмнэ.

```
git remote add upstream https://github.com/monkhsaikhan/nbfis.git
```

Энэ remote-р үндсэн кодын шинэчлэлүүдээ татаж авна.

```
git fetch upstream `branch_name`
```

Энэ нь <code>upstream/'branch_name'</code> дээр татагдана. Дараа нь үндсэн branch-тай нэгтгэнэ

```
git merge upstream/`branch_name`
```

Command line - с дараах command-уудыг дарааллын дагуу ажиллуулана.

```
composer update
```

```
copy .env.example .env
```

.env file дээрх 16 мөрөнд байгаа <code>CACHE_DRIVER=file  => CACHE_DRIVER=array</code> өөрчилнө

```
php artisan key:generate
```

```
npm install
```

```
npm run dev
```

```
php artisan migrate
```

```
php artisan db:seed
```

### Системд нэвтрэх

<p>username: admin@woovoo.com</p>
<p>password: root</p>