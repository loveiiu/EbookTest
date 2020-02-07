<style>
ul { /* 取消ul預設的內縮及樣式 */
        margin: 0;
        padding: 0;
        list-style: none;
    }

    ul.drop-down-menu {
        border: #ccc 3px solid;
        display: inline-block;
        font-family: 'Open Sans', Microsoft JhengHei, sans-serif;
        font-size: 14px;
    }

    ul.drop-down-menu li {
        position: relative;
        white-space: nowrap;
        border-right: #ccc 1px solid;
    }

    ul.drop-down-menu > li:last-child {
        border-right: none;
    }

    ul.drop-down-menu > li {
        float: left; /* 只有第一層是靠左對齊*/
    }

     ul.drop-down-menu a {
        background-color: #fff;
        color: #666666;
        display: block;
        padding: 0 30px;
        text-decoration: none;
        line-height: 40px;

    }
    ul.drop-down-menu a:hover { /* 滑鼠滑入按鈕變色*/
        background-color: #F499CC;
        color: #fff;
    }
    ul.drop-down-menu li:hover > a { /* 滑鼠移入次選單上層按鈕保持變色*/
        background-color: #F499CC;
        color: #fff;
    }

    ul.drop-down-menu ul {
        border: #ccc 1px solid;
        position: absolute;
        z-index: 99;
        left: -1px;
        top: 100%;
       min-width: 180px;
    }

    ul.drop-down-menu ul li {
        border-bottom: #ccc 1px solid;
    }

    ul.drop-down-menu ul li:last-child {
        border-bottom: none;
    }

    ul.drop-down-menu ul { /*隱藏次選單*/
        display: none;
    }

    ul.drop-down-menu li:hover > ul { /* 滑鼠滑入展開次選單*/
        display: block;
    }
    .current {
        background-color:#FFF2F2;
        display:block; 
        font-weight:bold;
    }
</style>
<title>TAAZE 電子書建檔後台</title>

<a href="/winphp/EbookTest/ebooktest.php"><img src="/winphp/EbookTest/ebooklogo.png" height="44" width="250"></a>
<br>
<ul class="drop-down-menu">
        <li><a>每日建檔</a>
            <ul>
                <li><a href="/winphp/EbookTest/ebookmainprocess1.php">(1)抓特定出版社excel</a>
                </li>
				<li><a href="/winphp/EbookTest/ebookmainprocess1all.php">(1)抓全部出版社excel</a>
                </li>
                <li><a href="/winphp/EbookTest/ebookmainprocess2.php">(2)寫入ebook_meta，設定書籍出版形式&雜誌meta</a>
                </li>
                <li><a href="/winphp/EbookTest/ebookmainprocess3.php">(3)下載原始檔</a>
                </li>
                <li><a href="/winphp/EbookTest/ebookmainprocess45.php">(4)(5)寫入電子書後臺及審核模組，建立書封</a>
                </li>
				<li><a href="/winphp/EbookTest/ebookmainprocessf.php">(final)複製檔案到電子書PDF-待檢查-全</a>
                </li>
                <li><a href="/winphp/EbookTest/ebookmainprocessmail.php">(Mail)寄建檔信</a>
                </li>
            </ul>
        </li>
        <li><a>處理音檔</a>
            <ul>
                <li><a href="/winphp/EbookTest/ProcessPdfMedia.php">(1)匯入音檔對應表</a>
                </li>
                <li><a href="/winphp/EbookTest/MappingAndCopyMedia.php">(2)(3)後臺填寫完畢再次匯入，放入暫存區</a>
                </li>
                <!--<li><a href="#">FTP補音檔</a>
                </li>-->
            </ul>
        </li>
        <li><a href="/winphp/EbookTest/ebookepubtodbnew.php">匯入Epub</a>
        </li>
        <li><a>上下架&開關車</a>
        <ul>
                <li><a href="/winphp/EbookTest/PutOnShelf.php">上架</a>
                </li>
                <li><a href="/winphp/EbookTest/StartSale.php">開車</a>
                </li>
                <li><a href="/winphp/EbookTest/StopSale.php">關車</a>
                </li>
                <li><a href="/winphp/EbookTest/RemoveFromShelf.php">下架</a>
                </li>

            </ul>
        </li>
        <li><a>打包</a>
			<ul>
				<li><a href="/winphp/EbookTest/DBToEbook0.php">(0)前置處理</a>
                </li>
				<li><a href="/winphp/EbookTest/DBToEbook1.php">(1)開始執行</a>
                </li>
				<!--<li><a href="#">處理ePub</a>
                </li>
				<li><a href="#">處理pdf</a>
                </li>
				<li><a href="#">處理特定檔案</a>
                </li>-->
				<li><a href="/winphp/EbookTest/DBToEbook2.php">(2)檔案搬到Mac</a>
                </li>
				<li><a href="/winphp/EbookTest/DBToEbook4.php">(4)搬到NAS並更改打包狀態</a>
                </li>
			</ul>
        </li>
		<li><a>從(2.已除錯PDF)抓檔</a>
			<ul>
			<li><a href="/winphp/EbookTest/PrepareToProduce.php">抓檔</a>
			</li>
			<li><a href="/winphp/EbookTest/PdfToImage.php">轉檔</a>
			</li>
			<li><a href="/winphp/EbookTest/ebookencode.php">加密</a>
			</li>
			</ul>
		</li>
		<li><a>特殊情況</a>
			<ul>
				<li><a href="/winphp/EbookTest/deleteDuplicateEbook.php">刪除重複建檔</a>
				</li>
				<li><a href="/winphp/EbookTest/MagzMetaMap.php">未找到對應雜誌</a>
				</li>
				<li><a href="/winphp/EbookTest/FailDownloadFiles.php">原始檔下載失敗</a>
				</li>
			</ul>
		</li>
    </ul>
