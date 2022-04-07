<div class="text-right">
    <button class="btn btn-primary btn-sm icon md-print" onclick="printJS('cv', 'html')"></button>
    <button class="btn btn-primary btn-sm icon md-download" id="savepdf"></button>
</div>
<div style="padding: 30px">
    <div id="cv">
        <div style="padding: 20px;background: whitesmoke;">
            <h1 style="text-align: center;color: #cf8a05">{{$data->data->firstName}} {{$data->data->lastName}} {{$data->data->patonymic}}</h1>
        </div>
        <table style="width: 100%">
            <tr>
                <td width="25%"><img src="data:image/png;base64,{{!empty($data->data->photo) ? $data->data->photo : ''}}" width="100%"/></td>
                <td width="5%"></td>
                <td width="30%">
                    <div>
                        <div style="display: block">
                            <h4 >Doğum tarixi : {{!empty($data->data->birthDate) ? date('d.m.Y' , strtotime($data->data->birthDate)) : ''}}</h4>
                        </div>
                        <div style="display: block">
                            <h4 >Doğum yeri : {{$data->data->birthPlace}}</h4>
                        </div>
                        <div style="display: block">
                            <h4>Milliyəti : {{$data->data->nationalityName}}</h4>
                        </div>
                        <div style="display: block">
                            <h4 >Qeydiyyat ünvanı : {{$data->data->registrationAddress}}</h4>
                        </div>
                        <div style="display: block">
                            <h4>Yaşayış ünvanı : {{!empty($data->data->residenceAddress) ? $data->data->residenceAddress : ''}}</h4>
                        </div>
                        <div style="display: block">
                            <h4>Ailə vəziyyəti : {{!empty($data->data->familyStatusName) ? $data->data->familyStatusName : ''}}</h4>
                        </div>
                    </div>
                </td>
                <td width="30%">
                    <div>
                        <div style="display: block">
                            <h4 >Ş.V № : {{$data->data->docNumber}}</h4>
                        </div>
                        <div style="display: block">
                            <h4 >FİN : {{$data->data->pin}}</h4>
                        </div>
                        <div style="display: block">
                            <h4 >Sənədin verilmə tarixi : {{!empty($data->data->docIssueDate) ? $data->data->docIssueDate : ''}}</h4>
                        </div>
                        <div style="display: block">
                            <h4 >Sənədi verən orqan : {{$data->data->docOrgan}}</h4>
                        </div>
                    </div>
                </td>
            </tr>

            </table>
        <div>
            @if(count($data->data->userPositions) > 0)
            <section style="width: 100%;display: flex;border-top:2px solid #cf8a05;margin-top: 20px">
                <div style="width:20%">
                    <h1 style="color: #cf8a05">Əmək fəaliyyəti</h1>
                </div>
                <div style="width:10%"></div>
                <div style="width: 60%">
                    @foreach($data->data->userPositions as $position)
                    <article>
                        <h2>{{$position->organizationName}}</h2>
                        <h4>{{$position->positionName}}</h4>
                        <p>{{!empty($position->startDate) ? $position->startDate : ''}} {{!empty($position->endDate) ? ' - '.$position->endDate : ''}}</p>
                    </article>
                    <article>
                        <h2>{{$position->organizationName}}</h2>
                        <h4>{{$position->positionName}}</h4>
                        <p>{{!empty($position->startDate) ? $position->startDate : ''}} {{!empty($position->endDate) ? ' - '.$position->endDate : ''}}</p>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

            @if(count($data->data->userEducations) > 0)
            <section style="width: 100%;display: flex;border-top:2px solid #cf8a05;margin-top: 20px">
                <div style="width:20%">
                    <h1 style="color: #cf8a05">Təhsil</h1>
                </div>
                <div style="width:10%"></div>
                <div style="width: 60%">
                    @foreach($data->data->userEducations as $education)
                    <article style="margin-bottom: 20px">
                        <h2>Təhsil müəsisəsi: <strong>{{$education->educationalInstitutionName}}</strong> </h2>
                        <h4>Fakültə: <strong>{{$education->professionName}}</strong></h4>
                        <h4>Təhsil səviyyəsi: <strong>{{$education->educationLevelName}} {{$education->educationFormName}}</strong></h4>
                        <p>{{!empty($education->eduStartDate) ? date('d.m.Y' , strtotime($education->eduStartDate)) : ''}} {{!empty($education->eduEndDate) ? ' - '.date('d.m.Y' , strtotime($education->eduEndDate)) : ''}}</p>
                    </article>
                    @endforeach
                </div>
                <div class="clear" style="height: 20px;"></div>
            </section>
            @endif

            @if(count($data->data->userLanguages) > 0)
                    <section style="width: 100%;display: flex;border-top:2px solid #cf8a05;margin-top: 20px">
                        <div style="width:20%">
                            <h1 style="color: #cf8a05">Dil bilikləri</h1>
                        </div>
                        <div style="width:10%"></div>
                        <div style="width: 60%">
                        <article>
                            <table class="table" style="margin-top: 20px">
                                <thead>
                                <tr>
                                    <th style="width: 30%">№</th>
                                    <th style="width: 30%">Dil</th>
                                    <th style="width: 30%">Səviyyəsi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->data->userLanguages as $key => $language)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$language->languageName}}</td>
                                        <td>{{$language->knowledgeLevelName}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </article>

                    </div>
                    <div class="clear"></div>
                </section>
            @endif

            @if(count($data->data->userContacts) > 0)
                    <section style="width: 100%;display: flex;border-top:2px solid #cf8a05;margin-top: 20px">
                        <div style="width:20%">
                            <h1 style="color: #cf8a05">Əlaqə</h1>
                        </div>
                        <div style="width:10%"></div>
                        <div style="width: 60%">
                        <article>
                            <table class="table" style="margin-top: 20px">
                                <thead>
                                <tr>
                                    <th style="width: 30%">Əlaqə vasitəsi</th>
                                    <th style="width: 30%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->data->userContacts as $key => $contact)
                                    <tr>
                                        <td>{{$contact->contactTypeName}}</td>
                                        <td>{{$contact->contactInfo}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </article>

                    </div>
                    <div class="clear"></div>
                </section>
            @endif

            @if(count($data->data->userTraining) > 0)
                    <section style="width: 100%;display: flex;border-top:2px solid #cf8a05;margin-top: 20px">
                        <div style="width:20%">
                            <h1 style="color: #cf8a05">İştirak etdiyi təlimlər</h1>
                        </div>
                        <div style="width:10%"></div>
                        <div style="width: 60%">
                        <article>
                            <table class="table" style="margin-top: 20px">
                                <thead>
                                <tr>
                                    <th style="width: 30%">Adı</th>
                                    <th style="width: 30%">İştirak forması</th>
                                    <th style="width: 30%">Tarix</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->data->userTraining as $key => $training)
                                    <tr>
                                        <td>{{$training->trainingName}}</td>
                                        <td>{{$training->traiingForm}}</td>
                                        <td>{{!empty($training->trainingStartDate) ? date('d.m.Y' , strtotime($training->trainingStartDate)) : ''}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </article>

                    </div>
                    <div class="clear"></div>
                </section>
            @endif

            @if(count($data->data->userRanks) > 0)
                <section style="width: 100%;display: flex;border-top:2px solid #cf8a05;margin-top: 20px">
                    <div style="width:20%">
                        <h1 style="color: #cf8a05">Hərbi rütbə</h1>
                    </div>
                    <div style="width:10%"></div>
                    <div style="width: 60%">
                        <article>
                            <table class="table" style="margin-top: 20px">
                                <thead>
                                <tr>
                                    <th style="width: 20%">Xüsusi rütbənin növü</th>
                                    <th style="width: 20%">Xüsusi rütbə</th>
                                    <th style="width: 20%">Verilmə tarixi</th>
                                    <th style="width: 20%">Sənədin tarixi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->data->userRanks as $key => $rank)
                                    <tr>
                                        <td>{{$rank->specialRankType}}</td>
                                        <td>{{$rank->specialRankName}}</td>
                                        <td>{{!empty($rank->startDate) ? date('d.m.Y' , strtotime($rank->startDate)) : '' }}</td>
                                        <td>{{!empty($rank->docDate) ? date('d.m.Y' , strtotime($rank->docDate)) : '' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </article>

                    </div>
                    <div class="clear"></div>
                </section>
            @endif

            @if(count($data->data->userRewardGov) > 0)
                <section style="width: 100%;display: flex;border-top:2px solid #cf8a05;margin-top: 20px">
                    <div style="width:20%">
                        <h1 style="color: #cf8a05">Dövlət Təltifləri</h1>
                    </div>
                    <div style="width:10%"></div>
                    <div style="width: 60%">
                        <article>
                            <table class="table" style="margin-top: 20px">
                                <thead>
                                <tr>
                                    <th style="width: 20%">Təltiflər</th>
                                    <th style="width: 20%">Verilmə tarixi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->data->userRewardGov as $key => $rank)
                                    <tr>
                                        <td>{{$rank->rewardGovName}}</td>
                                        <td>{{!empty($rank->issueDate) ? date('d.m.Y' , strtotime($rank->issueDate)) : '' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </article>

                    </div>
                    <div class="clear"></div>
                </section>
            @endif

            @if(count($data->data->userAcademicDegree) > 0)
                <section style="width: 100%;display: flex;border-top:2px solid #cf8a05;margin-top: 20px">
                    <div style="width:20%">
                        <h1 style="color: #cf8a05">Elmi dərəcə</h1>
                    </div>
                    <div style="width:10%"></div>
                    <div style="width: 60%">
                        <article>
                            <table class="table" style="margin-top: 20px">
                                <thead>
                                <tr>
                                    <th style="width: 20%">Elmi dərəcə (elmi ad)</th>
                                    <th style="width: 20%">Elmi istiqamət</th>
                                    <th style="width: 20%">Kim tərəfindən verilib</th>
                                    <th style="width: 20%">Verildiyi tarix</th>
                                    <th style="width: 20%">Müvafiq sənədin nömrəsi, tarixi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->data->userAcademicDegree as $key => $rank)
                                    <tr>
                                        <td>{{$rank->academicDegreeName}}</td>
                                        <td>{{$rank->academicAreaName}}</td>
                                        <td>{{!empty($rank->issueDate) ? date('d.m.Y' , strtotime($rank->issueDate)) : '' }}</td>
                                        <td>{{$rank->orgName}}</td>
                                        <td>{{$rank->docInfo}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </article>

                    </div>
                    <div class="clear"></div>
                </section>
            @endif

            @if(count($data->data->userFamily) > 0)
                    <section style="width: 100%;display: flex;border-top:2px solid #cf8a05;margin-top: 20px">
                        <div style="width:20%">
                            <h1 style="color: #cf8a05">Ailə tərkibi</h1>
                        </div>
                        <div style="width:10%"></div>
                        <div style="width: 60%">
                        <article>
                            <table class="table" style="margin-top: 20px"   >
                                <thead>
                                <tr>
                                    {{--<th style="width: 30%">Qohumluq dərəcəsi</th>--}}
                                    {{--<th style="width: 30%">Adı</th>--}}
                                    {{--<th style="width: 30%">Soyadı</th>--}}
                                    {{--<th style="width: 30%">Atasının adı</th>--}}
                                    {{--<th style="width: 30%">Doğulduğu tarix</th>--}}
                                    {{--<th style="width: 30%">İş yeri və vəzifəsi</th>--}}
                                    {{--<th style="width: 30%">Yaşadığı ünvan</th>--}}
                                    <th>Qohumluq dərəcəsi</th>
                                    <th>Adı</th>
                                    <th>Soyadı</th>
                                    <th>Atasının adı</th>
                                    <th>Doğulduğu tarix</th>
                                    <th>İş yeri və vəzifəsi</th>
                                    <th>Yaşadığı ünvan</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->data->userFamily as $key => $family)
                                    <tr>
                                        <td>{{$family->familyRelationTypeName}}</td>
                                        <td>{{$family->name}}</td>
                                        <td>{{$family->surname}}</td>
                                        <td>{{$family->middlename}}</td>
                                        <td>{{!empty($family->birthDate) ? date('d.m.Y' , strtotime($family->birthDate)) : ''}}</td>
                                        <td>{{$family->position}}</td>
                                        <td>{{$family->placeOfLive}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </article>
                    </div>
                    <div class="clear"></div>
                </section>
            @endif
        </div>
    </div>
</div>
<script>
    $('#savepdf').on('click' , function () {
        $('#cv').wordExport('test');
    })

    /**
     * Export to Word
     */
    if (typeof jQuery !== "undefined" && typeof saveAs !== "undefined") {
        (function($) {
            $.fn.wordExport = function(fileName) {
                fileName = typeof fileName !== 'undefined' ? fileName : "jQuery-Word-Export";
                var static = {
                    mhtml: {
                        top: "Mime-Version: 1.0\nContent-Base: " + location.href + "\nContent-Type: Multipart/related; boundary=\"NEXT.ITEM-BOUNDARY\";type=\"text/html\"\n\n--NEXT.ITEM-BOUNDARY\nContent-Type: text/html; charset=\"utf-8\"\nContent-Location: " + location.href + "\n\n<!DOCTYPE html>\n<html>\n_html_</html>",
                        head: "<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n<style>\n_styles_\n</style>\n</head>\n",
                        body: "<body>_body_</body>"
                    }
                };
                var options = {
                    maxWidth: 624
                };
                // Clone selected element before manipulating it
                var markup = $(this).clone();

                // Remove hidden elements from the output
                markup.each(function() {
                    var self = $(this);
                    if (self.is(':hidden'))
                        self.remove();
                });

                // Embed all images using Data URLs
                var images = Array();
                var img = markup.find('img');
                for (var i = 0; i < img.length; i++) {
                    // Calculate dimensions of output image
                    var w = Math.min(img[i].width, options.maxWidth);
                    var h = img[i].height * (w / img[i].width);
                    // Create canvas for converting image to data URL
                    var canvas = document.createElement("CANVAS");
                    canvas.width = w;
                    canvas.height = h;
                    // Draw image to canvas
                    var context = canvas.getContext('2d');
                    context.drawImage(img[i], 0, 0, w, h);
                    // Get data URL encoding of image
                    var uri = canvas.toDataURL("image/png");
                    $(img[i]).attr("src", img[i].src);
                    img[i].width = w;
                    img[i].height = h;
                    // Save encoded image to array
                    images[i] = {
                        type: uri.substring(uri.indexOf(":") + 1, uri.indexOf(";")),
                        encoding: uri.substring(uri.indexOf(";") + 1, uri.indexOf(",")),
                        location: $(img[i]).attr("src"),
                        data: uri.substring(uri.indexOf(",") + 1)
                    };
                }

                // Prepare bottom of mhtml file with image data
                var mhtmlBottom = "\n";
                for (var i = 0; i < images.length; i++) {
                    mhtmlBottom += "--NEXT.ITEM-BOUNDARY\n";
                    mhtmlBottom += "Content-Location: " + images[i].location + "\n";
                    mhtmlBottom += "Content-Type: " + images[i].type + "\n";
                    mhtmlBottom += "Content-Transfer-Encoding: " + images[i].encoding + "\n\n";
                    mhtmlBottom += images[i].data + "\n\n";
                }
                mhtmlBottom += "--NEXT.ITEM-BOUNDARY--";

                //TODO: load css from included stylesheet
                var styles = "";

                // Aggregate parts of the file together
                var fileContent = static.mhtml.top.replace("_html_", static.mhtml.head.replace("_styles_", styles) + static.mhtml.body.replace("_body_", markup.html())) + mhtmlBottom;

                // Create a Blob with the file contents
                var blob = new Blob([fileContent], {
                    type: "application/msword;charset=utf-8"
                });
                saveAs(blob, fileName + ".doc");
            };
        })(jQuery);
    } else {
        if (typeof jQuery === "undefined") {
            console.error("jQuery Word Export: missing dependency (jQuery)");
        }
        if (typeof saveAs === "undefined") {
            console.error("jQuery Word Export: missing dependency (FileSaver.js)");
        }
    }
</script>
