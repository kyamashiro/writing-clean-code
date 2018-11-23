#良いコードとはなにか

## 良いコードの定義
1. 保守性が高い
2. すばやく効率的に動作する
3. 正確に動作する
4. 無駄な部分がない

## 良いコードの価値
* プロジェクトを強力に推し進める
シンプルで保守性が高く､安定したコードを書くことは品質や生産性を倍に高める｡

## 良い名前付け
一貫性があり､説明的である｡意味や意図を理解しやすい｡

## メソッド名
メソッドは処理を行うので､｢動詞｣+｢目的語｣になっていることが多い｡  
createXXX, makeXXXなど  
https://qiita.com/Ted-HM/items/7dde25dcffae4cdc7923  
http://d.hatena.ne.jp/r-west/20090510/1241962864  

インスタンスメソッドはオブジェクト名と組み合わせて呼ぶので､重複しないようにする｡  
dateFormatインスタンスのparseDateStringはDateが重複している｡  
dateFormat.parseDateString("2018-01-01");  
この場合はparseで十分理解できる｡  
dateFormat.parse("2018-01-01");  

## クラス名
良い名前が浮かばないときはクラスの役割を整理できていない｡  
複数の責務を担っていたり､役割が曖昧だったりする｡  
* クラスの名前付け=設計
クラス名の語彙は経験とともに高まる｡自分が知らない表現や概念は学ぶ必要がある｡

https://gihyo.jp/dev/serial/01/code/000204  
https://qiita.com/KeithYokoma/items/ee21fec6a3ebb5d1e9a8  
https://qiita.com/disc99/items/adff7ed5c497ac2674f4  

良い名前に対して意識を持って取り組んでいくことが大切｡  
知らないことは自分の中からは出てこないので､コードリーディングなどで知識を取り入れる必要がある｡  

* リンク  
サーチコード  
https://searchcode.com/  
GitHubのコード検索  
https://github.com/search  
略語検索  
https://www.acronymfinder.com/  

## スコープ
変数やメソッド､クラスが見える範囲のこと｡
｢見える｣とは使えるということ｡
｢使える｣とは言い換えるとそれらに｢依存する｣ということ｡
依存が大きいと修正範囲が広くなり､保守性に影響を与える｡
スコープを小さくすることで､依存が小さく､保守性の高いプログラムになる｡

フィールド変数はprivateが基本｡アクセサメソッドを用いる｡基本であって時と場合による｡
https://www.kaitoy.xyz/2015/07/22/getters-setters-evil/  

クラスメソッド
クラスメソッドはフィールド変数にアクセスできない｡フィールド変数が影響を受けないのでスコープの範囲が狭くなる｡
フィールド変数にアクセス､オーバーライドする必要がないメソッドはクラスメソッドにしたほうが良い場合が多い｡

メソッドの引数の情報量
```
public function getEmployee(int $empId)
{
    return $empDao->findById($empId);
}
```

```
public function getEmployee(Employee $emp)
{
    return $empDao->findById($emp->getId());
}
```
前者はidを引数に渡しているが､後者はobjectを引数に渡している｡
必要なのは社員IDのみだが､メソッドを利用する側は社員オブジェクトの他の情報も必要なのかと考えてしまう｡
前者のほうが引数の情報量が少ないので､引数に対して依存度が少ない｡

ただし引数が多くなる場合は､引数をオブジェクトにしたほうが良い｡
目安として引数の数が5つを超えるメソッドは引数をオブジェクトに検討するほうが良い｡
https://twitter.com/xharaken/status/1065050626223042560

## コードの分割
~~~
private function createElement(Document $doc, string $nodeName, string $textContent, Element $parent)
{
    $node = doc->createElement(nodeName);
    $node->setTextContent($textContent);
    //外部の状態を変更
    $this->appendChild($node);
}
~~~

状態を変更する場合､外部に対して副作用があるメソッドになる｡  
副作用があるメソッドは何が変更されるのか意識して使う必要がある｡  
副作用があるメソッドはテストを難しくしたり､再利用しにくい｡  

* 状態を持つ処理をクラスに抽出して分割する
長い範囲で使用される状態を表すローカル変数があるとリファクタリングしにくい｡
状態を持つローカル変数は処理自体をクラスに抽出する｡そして状態を表すローカル変数をフィールド変数に移動させる｡

## コードの集約
###1. 継承でまとめる

重複コードをメソッドとして抽出し､親クラスに移動してまとめる｡

* デメリット
    1. 親クラスが肥大化する｡
親クラスはすべての子クラスに必要な共通の振る舞いのみをもたせる｡
    2. 単一継承の制限
継承できる親クラスは1つのみ｡コードを広く共有するという意味では継承はそぐわない｡

###2. ユーティリティクラスにまとめる

ユーティリティクラスのメソッドは基本的に状態を持たない処理をstaticなメソッドとして定義する｡
状態をもたせたり､DBへアクセスする必要があるときはサービス層にまとめる｡

###3. サービス層にまとめる

レイヤ構造のアーキテクチャ
Webコントローラ層→サービス層→データアクセス層
Webコントローラ層にはアプリケーションの機能は書かずにサービス層を呼び出して処理を実行する｡
~~~
//ライセンスに関する処理を集めたサービスクラス
public class LicenseService {
    //DBからデータを取り出して判定をする処理など
}
~~~

###4. オブジェクトにまとめる
~~~
//フォルダに関するクラス
public class Folder {
    public static final int TYPE_NORMAL = 0;
    public static final int TYPE_SHARED = 1;
    public int type;
}

//フォルダアクションクラス
public class FolderAction {
    //共有フォルダか判定する処理
    public boolean isSharedFolder(Folder folder) {
        return folder.type == TYPE_SHARED;
    }
}
~~~
isSharedFolderメソッドは常にFolderが必要になるので､処理自体をFolderクラスにまとめてオブジェクトのメソッドとしてまとめる｡
~~~
//フォルダに関するクラス
public class Folder {
    public static final int TYPE_NORMAL = 0;
    public static final int TYPE_SHARED = 1;
    public int type;
    
        //共有フォルダか判定する処理
        public boolean isSharedFolder() {
            return type == TYPE_SHARED;
        }
}

//フォルダアクションクラス
public class FolderAction {

}
~~~
共有フォルダ化判定するメソッドをFolderクラスに移動して､FolderActionクラスでは呼び出すだけになった｡
対象の処理がアプリケーション全体で共通な場合は､オブジェクトに集約する｡

## 抽象化
画像ファイルの一覧を表示するWebアプリで抽象化を実践｡
Javaで書かれていたがPHPで書き直した｡
仕様としてFood,Animal,Landscapeディレクトリごとのファイルサイズの合計と画像のファイル名を表示させるというもの｡

~~~php
class ImageListAction
{
    public $food_files = [];
    public $animal_files = [];
    public $lands_scape_files = [];
    public $food_size;
    public $animal_size;
    public $land_scape_size;

    public function actionResult()
    {
        //この部分がべた書き｡重複が多い
        $this->food_files = glob('./data/images/food/*');
        $this->animal_files = glob('./data/images/animal/*');
        $this->lands_scape_files = glob('./data/images/landscape/*');
        $this->food_size = $this->sizeOfFiles($this->food_files);
        $this->animal_size = $this->sizeOfFiles($this->animal_files);
        $this->land_scape_size = $this->sizeOfFiles($this->lands_scape_files);
    }

    public function sizeOfFiles($file): int
    {
        $totalSize = 0;
        foreach ($file as $item) {
            $totalSize = filesize($item);
        }
        return $totalSize;
    }
}
~~~

~~~html
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>
    Food Photos (<?= round($imagelist->food_size / 1024); ?>KB)
</h2>
<ul>
    <?php foreach ($imagelist->food_files as $item): ?>
        <li>
            <?= basename($item) ?>
        </li>
    <?php endforeach; ?>
</ul>
<h2>
    Animal Photos (<?= round($imagelist->animal_size / 1024); ?>KB)
</h2>
<ul>
    <?php foreach ($imagelist->animal_files as $item): ?>
        <li>
            <?= basename($item) ?>
        </li>
    <?php endforeach; ?>
</ul>
<h2>
    Landscape Photos (<?= round($imagelist->land_scape_size / 1024); ?>KB)
</h2>
<ul>
    <?php foreach ($imagelist->lands_scape_files as $item): ?>
        <li>
            <?= basename($item) ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
~~~
最初の段階ではべた書きで重複が多い｡またカテゴリが増えたときやjpgだけを表示するなどの変更があったときに書き換える部分が多く変更に弱い｡
コードを抽象化して変更に強くする｡

* メソッドの抽出

~~~php
class FileUtil
{
    public static function sizeOfFiles($file): int
    {
        $totalSize = 0;
        foreach ($file as $item) {
            $totalSize = filesize($item);
        }
        return $totalSize;
    }
}
~~~

sizeOfFilesメソッドはフィールド変数にアクセスしてないので､Utilクラスに移動させた｡

* データ構造の整理

~~~php
class ImageListAction
{
    public $food_files = [];
    public $animal_files = [];
    public $lands_scape_files = [];
    public function actionResult()
    {
        $this->food_files = $this->getFiles('./data/images/food/*');
        $this->animal_files = $this->getFiles('./data/images/animal/*');
        $this->lands_scape_files = $this->getFiles('./data/images/landscape/*');
    }
    private function getFiles(string $path): ImageFiles
    {
        $files = glob($path);
        return new ImageFiles($files, FileUtil::sizeOfFiles($files));
    }
}
~~~

~~~php
class ImageFiles
{
    private $files;
    private $sizeOfFiles;
    /**
     * ImageFiles constructor.
     * @param $files
     * @param $sizeOfFiles
     */
    public function __construct($files, $sizeOfFiles)
    {
        $this->files = $files;
        $this->sizeOfFiles = $sizeOfFiles;
    }
    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }
    /**
     * @return mixed
     */
    public function getSizeOfFiles()
    {
        return $this->sizeOfFiles;
    }
}
~~~

ファイル一覧とファイルサイズを持つImageFilesクラスを作成｡

* 配列で抽象化

~~~php
class ImageListAction
{
    /**
     * @var array
     */
    public $paths = [
        'Food' => './data/images/food/*',
        'Animal' => './data/images/animal/*',
        'Landscape' => './data/images/landscape/*'
    ];
    /**
     * @var
     */
    public $file_list;
    /**
     *
     */
    public function actionResult(): void
    {
        foreach ($this->paths as $pic_category => $path) {
            $this->file_list[$pic_category] = $this->getFiles($path);
        }
    }
    /**
     * @param string $path
     * @return ImageFiles
     */
    private function getFiles(string $path): ImageFiles
    {
        $files = glob($path);
        return new ImageFiles($files, $path);
    }
}
~~~

~~~php
class ImageFiles
{
    private $path;
    private $files;
    private $sizeOfFiles;
    /**
     * ImageFiles constructor.
     * @param $files
     * @param string $path
     */
    public function __construct(array $files, string $path)
    {
        $this->files = $files;
        $this->path = $path;
        $this->sizeOfFiles = FileUtil::sizeOfFiles($files);
    }
    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
    /**
     * @return mixed
     */
    public function getFiles(): array
    {
        return $this->files;
    }
    /**
     * @return mixed
     */
    public function getSizeOfFiles(): int
    {
        return $this->sizeOfFiles;
    }
}
~~~

~~~html
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php foreach ($imagelist->file_list as $pic_category => $list): ?>
    <h2>
        <?= $pic_category ?> Photos (<?= round($list->getSizeOfFiles() / 1024); ?>KB)
    </h2>
    <?php foreach ($list->getFiles() as $file_name) : ?>
        <ul>
            <li>
                <?= basename($file_name) ?>
            </li>
        </ul>
    <?php endforeach; ?>
<?php endforeach; ?>
</body>
</html>
~~~

ImageListActionクラスでディレクトリのパスを連想配列として持たせ､foreachでパスを切り替えてImageFilesの生成を行いデータと処理を分離した｡
ディレクトリが追加されてもパスを配列に追加すれば良い｡
表示するviewもFood Photos,Animal Photosなど直接書いていたが､カテゴリを連想配列のキーにすることでループで処理できるようになった｡

Interfaceやabstractを使えばもっとうまく整理できそうな気がする｡ImageFilesの上位のFileクラスとか｡  
またUtilクラスにファイルの合計サイズを取得するメソッドを切り分けたのは､これがベストなんだろうか｡  
まぁ､状態を持たないし､画像ファイルにかかわらずファイルサイズを取得できるから汎用的ではあるんだろうけど｡  










