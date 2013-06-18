import requests
from pymongo import MongoClient
import re
import pprint


post_pattern = re.compile('<div class="post clearfix">(.*?)(?=<div class="post clearfix">|<div id="footer">)', re.M | re.S)
url_reg = re.compile(r'[\w\-\.]+\.(?:com|fr|co\.uk|net|info|org|dk|cz|gov|hu|tv|il|es|ro)(?=\W|<|\/)', re.I)
client = MongoClient().drano.pricing_rules


def is_record_existing(url):
    return client.find(dict(domain="http://" + url)).count() == 1


def record(url):
    doc = dict(
        broad_rules=["from:@" + url],
        name=url,
        severity="Password given",
        domain='http://' + url,
        uid=url.replace(".", "_"),
        extra_factors=[],
    )
    client.insert(doc)


root_url = 'http://plaintextoffenders.com/page/{page}'
cur_page = 1
page_urls = set()

while True:
    new_urls = 0
    r = requests.get(root_url.format(page=cur_page))
    for match in post_pattern.finditer(r.text):
        for url_match in url_reg.findall(match.group(1)):
            if "plaintextoffenders" not in url_match and "tumblr" not in url_match and "disqus.com" not in url_match:
                if not is_record_existing(url_match):
                    record(url_match)
                    page_urls.add(url_match)
                    new_urls += 1

    cur_page += 1
    if new_urls == 0:
        break

print len(page_urls)
pprint.pprint(page_urls)
